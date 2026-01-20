<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\RiceListing;
use App\Models\Order;
use App\Models\SellerBuyerProfile;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = auth()->user();
        
        $stats = [
            'total_listings' => $seller->riceListings()->count(),
            'active_listings' => $seller->riceListings()->where('status', 'active')->count(),
            'total_orders' => $seller->soldOrders()->count(),
            'pending_orders' => $seller->soldOrders()->whereIn('status', ['pending', 'confirmed', 'preparing', 'delivered'])->count(),
        ];

        $recentOrders = $seller->soldOrders()->with('buyer', 'riceListing')->latest()->limit(5)->get();

        return view('seller.dashboard', compact('stats', 'recentOrders'));
    }

    // Rice Listings Management
    public function listings()
    {
        $listings = auth()->user()->riceListings()->latest()->get();
        return view('seller.listings.index', compact('listings'));
    }

    public function createListing()
    {
        return view('seller.listings.create');
    }

    public function storeListing(Request $request)
    {
        $request->validate([
            'rice_variety' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'harvest_date' => 'nullable|string',
            'quality_grade' => 'required|in:premium,standard,economy',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['seller_id'] = auth()->id();
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('rice-listings', 'public');
        }

        $listing = RiceListing::create($data);

        SystemLog::createLog('create_listing', "Created rice listing: {$listing->rice_variety}", 'seller');

        return redirect()->route('seller.listings')->with('success', 'Rice listing created successfully');
    }

    public function editListing($id)
    {
        $listing = RiceListing::where('seller_id', auth()->id())->findOrFail($id);
        return view('seller.listings.edit', compact('listing'));
    }

    public function updateListing(Request $request, $id)
    {
        $listing = RiceListing::where('seller_id', auth()->id())->findOrFail($id);

        $request->validate([
            'rice_variety' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'harvest_date' => 'nullable|string',
            'quality_grade' => 'required|in:premium,standard,economy',
            'status' => 'required|in:active,sold_out,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($listing->image_path) {
                Storage::disk('public')->delete($listing->image_path);
            }
            $data['image_path'] = $request->file('image')->store('rice-listings', 'public');
        }

        $listing->update($data);

        SystemLog::createLog('update_listing', "Updated rice listing: {$listing->rice_variety}", 'seller');

        return redirect()->route('seller.listings')->with('success', 'Rice listing updated successfully');
    }

    public function deleteListing($id)
    {
        $listing = RiceListing::where('seller_id', auth()->id())->findOrFail($id);
        
        if ($listing->image_path) {
            Storage::disk('public')->delete($listing->image_path);
        }

        $variety = $listing->rice_variety;
        $listing->delete();

        SystemLog::createLog('delete_listing', "Deleted rice listing: {$variety}", 'seller');

        return back()->with('success', 'Rice listing deleted successfully');
    }

    // Orders Management
    public function orders()
    {
        $orders = auth()->user()->soldOrders()->with('buyer', 'riceListing')->latest()->get();
        return view('seller.orders.index', compact('orders'));
    }

    public function viewOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->with('buyer', 'riceListing')->findOrFail($id);
        return view('seller.orders.view', compact('order'));
    }

    public function confirmOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->where('status', 'pending')->findOrFail($id);
        $order->update(['status' => 'confirmed', 'confirmed_at' => now()]);

        SystemLog::createLog('confirm_order', "Confirmed order: {$order->order_number}", 'seller');

        return back()->with('success', 'Order confirmed successfully');
    }

    public function prepareOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->where('status', 'confirmed')->findOrFail($id);
        $order->update(['status' => 'preparing']);

        SystemLog::createLog('prepare_order', "Preparing order: {$order->order_number}", 'seller');

        return back()->with('success', 'Order is now being prepared');
    }

    public function deliverOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->whereIn('status', ['confirmed', 'preparing'])->findOrFail($id);
        $order->update(['status' => 'delivered', 'delivered_at' => now()]);

        SystemLog::createLog('deliver_order', "Delivered order: {$order->order_number}", 'seller');

        return back()->with('success', 'Order marked as delivered');
    }

    public function completeOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->where('status', 'delivered')->findOrFail($id);
        $order->markAsCompleted();

        SystemLog::createLog('complete_order', "Completed order: {$order->order_number}", 'seller');

        return back()->with('success', 'Order marked as completed');
    }

    public function cancelOrder($id)
    {
        $order = Order::where('seller_id', auth()->id())->where('status', 'pending')->findOrFail($id);
        
        // Return stock to listing
        $listing = $order->riceListing;
        $listing->quantity_available += $order->quantity;
        if ($listing->status === 'sold_out') {
            $listing->status = 'active';
        }
        $listing->save();

        $order->update(['status' => 'cancelled']);

        SystemLog::createLog('cancel_order', "Cancelled order: {$order->order_number}", 'seller');

        return back()->with('success', 'Order cancelled successfully');
    }

    // Profile Management
    public function profile()
    {
        $profile = auth()->user()->profile ?? new SellerBuyerProfile();
        return view('seller.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'barangay' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'province' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bio' => 'nullable|string|max:500',
        ]);

        $profile = auth()->user()->profile;

        if (!$profile) {
            $profile = new SellerBuyerProfile();
            $profile->user_id = auth()->id();
            $profile->user_type = 'seller';
        }

        $profile->fill($request->all());
        $profile->save();

        SystemLog::createLog('update_profile', 'Updated seller profile', 'seller');

        return back()->with('success', 'Profile updated successfully');
    }
}
