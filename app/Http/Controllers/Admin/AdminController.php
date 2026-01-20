<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\RiceListing;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_sellers' => User::where('role', 'seller')->count(),
            'pending_sellers' => User::where('role', 'seller')->where('status', 'pending')->count(),
            'total_buyers' => User::where('role', 'buyer')->count(),
            'total_listings' => RiceListing::count(),
            'total_orders' => Order::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // User Management
    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:seller,buyer,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'approved',
        ]);

        SystemLog::createLog('create_user', "Created user: {$request->email}", 'admin');

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        SystemLog::createLog('approve_user', "Approved user: {$user->email}", 'admin');

        return back()->with('success', 'User approved successfully');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        SystemLog::createLog('reject_user', "Rejected user: {$user->email}", 'admin');

        return back()->with('success', 'User rejected');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = $user->status === 'inactive' ? 'approved' : 'inactive';
        $user->update(['status' => $newStatus]);

        SystemLog::createLog('toggle_user_status', "Changed user status to {$newStatus}: {$user->email}", 'admin');

        return back()->with('success', 'User status updated');
    }

    // Reports
    public function reports()
    {
        return view('admin.reports.index');
    }

    public function sellerReport()
    {
        $sellers = User::where('role', 'seller')
            ->withCount(['riceListings', 'soldOrders'])
            ->get();

        return view('admin.reports.sellers', compact('sellers'));
    }

    public function buyerReport()
    {
        $buyers = User::where('role', 'buyer')
            ->withCount('purchasedOrders')
            ->get();

        return view('admin.reports.buyers', compact('buyers'));
    }

    public function pricingReport()
    {
        $listings = RiceListing::with('seller')->get();
        return view('admin.reports.pricing', compact('listings'));
    }

    // View all listings
    public function listings()
    {
        $listings = RiceListing::with('seller')->latest()->get();
        return view('admin.listings', compact('listings'));
    }

    // View all transactions
    public function transactions()
    {
        $orders = Order::with(['buyer', 'seller', 'riceListing'])->latest()->get();
        return view('admin.transactions', compact('orders'));
    }

    // System logs
    public function logs()
    {
        $logs = SystemLog::with('user')->latest()->paginate(50);
        return view('admin.logs', compact('logs'));
    }

    // Profile Management
    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Update name
        $user->name = $request->name;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        SystemLog::createLog('update_profile', 'Updated admin profile', 'admin');

        return back()->with('success', 'Profile updated successfully');
    }
}
