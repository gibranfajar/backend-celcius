<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            // cek apakah user memiliki peran admin
            if (auth()->user()->role == 'admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses sebagai admin');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah');
    }

    public function dashboard()
    {
        $title = 'Dashboard';

        // Data default (Hari Ini)
        $orders = Order::whereDate('created_at', Carbon::today())->count();
        $customers = User::where('role', 'user')->count();
        $total = Order::whereDate('created_at', Carbon::today())->sum('gross_amount');

        return view('dashboard', compact('title', 'orders', 'customers', 'total'));
    }

    // Metode untuk AJAX request filter
    public function filterDashboard(Request $request)
    {
        $filter = $request->filter;
        $previousOrders = 0;
        $previousTotal = 0;

        if ($filter == 'today') {
            $currentRange = Carbon::today();
            $previousRange = Carbon::yesterday();
        } elseif ($filter == 'month') {
            $currentRange = Carbon::now()->startOfMonth();
            $previousRange = Carbon::now()->subMonth()->startOfMonth();
        } elseif ($filter == 'year') {
            $currentRange = Carbon::now()->startOfYear();
            $previousRange = Carbon::now()->subYear()->startOfYear();
        }

        // Data saat ini
        $orders = Order::where('created_at', '>=', $currentRange)->count();
        $total = Order::where('created_at', '>=', $currentRange)->sum('gross_amount');

        // Data sebelumnya (untuk perhitungan persentase)
        $previousOrders = Order::where('created_at', '>=', $previousRange)->where('created_at', '<', $currentRange)->count();
        $previousTotal = Order::where('created_at', '>=', $previousRange)->where('created_at', '<', $currentRange)->sum('gross_amount');

        // Hitung persentase perubahan
        $orderChange = $previousOrders > 0 ? (($orders - $previousOrders) / $previousOrders) * 100 : 0;
        $totalChange = $previousTotal > 0 ? (($total - $previousTotal) / $previousTotal) * 100 : 0;

        return response()->json([
            'orders' => number_format($orders, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.'),
            'orderChange' => number_format($orderChange, 2, ',', '.'),
            'totalChange' => number_format($totalChange, 2, ',', '.'),
            'filterLabel' => ucfirst($filter) // Agar tampil "Today", "This Month", "This Year"
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
