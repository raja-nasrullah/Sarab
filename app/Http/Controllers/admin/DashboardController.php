<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\MenuItem;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function sales()
    {
        // 1. Fetch the real data
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();
        $totalMenuItems = MenuItem::count();
        $pendingReservations = Reservation::where('status', 'pending')
                            ->where('reservation_date', '>=', Carbon::today())
                            ->count();

        $recentOrders = Order::with('customer')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        $upcomingReservations = Reservation::with('customer', 'table')
                                ->where('reservation_date', '>=', Carbon::today())
                                ->orderBy('reservation_date', 'asc')
                                ->take(5)
                                ->get();

        // 2. Return the exact same view with the data
        return view('admin.pages.index3', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalMenuItems',
            'pendingReservations',
            'recentOrders',
            'upcomingReservations'
        ));
    }
}