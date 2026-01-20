<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\RiceListing;
use App\Models\Order;
use App\Models\Feedback;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $buyer = auth()->user();
        
        $stats = [
            'total_orders' => $buyer->purchasedOrders()->count(),
            'pending_orders' => $buyer->purchasedOrders()->whereIn('status', ['pending', 'confirmed', 'preparing', 'delivered'])->count(),
            'completed_orders' => $buyer->purchasedOrders()->where('status', 'completed')->count(),
        ];

        $recentOrders = $buyer->purchasedOrders()->with('seller', 'riceListing')->latest()->limit(5)->get();

        return view('buyer.dashboard', compact('stats', 'recentOrders'));
    }

    // Browse Rice Listings
    public function browse(Request $request)
    {
        $query = RiceListing::with('seller')->where('status', 'active')->where('quantity_available', '>', 0);

        // Filter by rice type
        if ($request->filled('rice_type')) {
            $query->where('rice_variety', 'like', '%' . $request->rice_type . '%');
        }

        // Filter by barangay
        if ($request->filled('barangay')) {
            $query->where('location', 'like', '%' . $request->barangay . '%');
        }

        // Filter by municipality
        if ($request->filled('municipality')) {
            $query->where('location', 'like', '%' . $request->municipality . '%');
        }

        // Sort by price
        if ($request->filled('sort') && $request->sort === 'price_low') {
            $query->orderBy('price_per_kg', 'asc');
        } else {
            $query->latest();
        }

        $listings = $query->paginate(12);

        return view('buyer.browse', compact('listings'));
    }

    public function viewListing($id)
    {
        $listing = RiceListing::with('seller.profile')->findOrFail($id);
        return view('buyer.view-listing', compact('listing'));
    }

    // Place Order
    public function placeOrderForm($listingId)
    {
        $listing = RiceListing::with('seller')->findOrFail($listingId);

        if (!$listing->isAvailable()) {
            return redirect()->route('buyer.browse')->with('error', 'This rice listing is no longer available');
        }

        return view('buyer.place-order', compact('listing'));
    }

    public function placeOrder(Request $request, $listingId)
    {
        $listing = RiceListing::findOrFail($listingId);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $listing->quantity_available,
            'delivery_address' => 'required|string',
            'contact_number' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $totalAmount = $listing->price_per_kg * $request->quantity;

        $order = Order::create([
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)),
            'buyer_id' => auth()->id(),
            'seller_id' => $listing->seller_id,
            'rice_listing_id' => $listing->id,
            'quantity' => $request->quantity,
            'price_per_kg' => $listing->price_per_kg,
            'total_amount' => $totalAmount,
            'delivery_address' => $request->delivery_address,
            'contact_number' => $request->contact_number,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Reduce stock
        $listing->reduceStock($request->quantity);

        SystemLog::createLog('place_order', "Placed order: {$order->order_number}", 'buyer');

        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully! Order Number: ' . $order->order_number);
    }

    // View Orders
    public function orders()
    {
        $orders = auth()->user()->purchasedOrders()->with('seller', 'riceListing')->latest()->get();
        return view('buyer.orders.index', compact('orders'));
    }

    public function viewOrder($id)
    {
        $order = Order::where('buyer_id', auth()->id())->with('seller', 'riceListing', 'feedback')->findOrFail($id);
        return view('buyer.orders.view', compact('order'));
    }

    // Submit Feedback
    public function submitFeedbackForm($orderId)
    {
        $order = Order::where('buyer_id', auth()->id())->where('status', 'completed')->findOrFail($orderId);

        // Check if feedback already exists
        if ($order->feedback) {
            return back()->with('error', 'You have already submitted feedback for this order');
        }

        return view('buyer.feedback', compact('order'));
    }

    public function submitFeedback(Request $request, $orderId)
    {
        $order = Order::where('buyer_id', auth()->id())->where('status', 'completed')->findOrFail($orderId);

        // Check if feedback already exists
        if ($order->feedback) {
            return back()->with('error', 'You have already submitted feedback for this order');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Feedback::create([
            'order_id' => $order->id,
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $order->seller_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'feedback_type' => 'buyer_to_seller',
        ]);

        // Update seller rating
        $seller = $order->seller;
        $allFeedback = $seller->receivedFeedback;
        $avgRating = $allFeedback->avg('rating');
        
        if ($seller->profile) {
            $seller->profile->update([
                'rating' => round($avgRating, 2),
                'total_transactions' => $seller->profile->total_transactions + 1,
            ]);
        }

        SystemLog::createLog('submit_feedback', "Submitted feedback for order: {$order->order_number}", 'buyer');

        return redirect()->route('buyer.orders')->with('success', 'Thank you for your feedback!');
    }
}
