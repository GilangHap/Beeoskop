<?php

namespace App\Livewire\Admin;

use App\Models\Film;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\JadwalTayang;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    #[Layout('livewire.components.layouts.admin')]
    
    public $totalRevenue;
    public $totalBookings;
    public $activeUsers;
    public $upcomingScreenings;
    public $recentTransactions;
    
    // Untuk perbandingan peningkatan/penurunan
    public $revenuePercentChange;
    public $bookingsPercentChange;
    public $usersPercentChange;
    public $screeningsPercentChange;
    
    public $isModalOpen = false;
    public $selectedTransaction = null;

    public function mount()
    {
        // Total Revenue (dari semua transaksi berhasil)
        $this->totalRevenue = Transaksi::where('payment_status', 'Success')
            ->sum('total_payment');
            
        // Revenue bulan ini vs bulan lalu untuk persentase
        $currentMonthRevenue = Transaksi::where('payment_status', 'Success')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_payment');
            
        $lastMonthRevenue = Transaksi::where('payment_status', 'Success')
            ->whereMonth('transaction_date', now()->subMonth()->month)
            ->whereYear('transaction_date', now()->subMonth()->year)
            ->sum('total_payment');
            
        if ($lastMonthRevenue > 0) {
            $this->revenuePercentChange = round((($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1);
        } else {
            $this->revenuePercentChange = $currentMonthRevenue > 0 ? 100 : 0;
        }
        
        // Total Bookings (semua transaksi)
        $this->totalBookings = Transaksi::count();
        
        // Bookings bulan ini vs bulan lalu untuk persentase
        $currentMonthBookings = Transaksi::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->count();
            
        $lastMonthBookings = Transaksi::whereMonth('transaction_date', now()->subMonth()->month)
            ->whereYear('transaction_date', now()->subMonth()->year)
            ->count();
            
        if ($lastMonthBookings > 0) {
            $this->bookingsPercentChange = round((($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100, 1);
        } else {
            $this->bookingsPercentChange = $currentMonthBookings > 0 ? 100 : 0;
        }
            
        // Active Users (total users)
        $this->activeUsers = User::where('role', '!=', 'admin')->count();
        
        // Users bulan ini vs bulan lalu untuk persentase
        $currentMonthUsers = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $lastMonthUsers = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
            
        if ($lastMonthUsers > 0) {
            $this->usersPercentChange = round((($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1);
        } else {
            $this->usersPercentChange = $currentMonthUsers > 0 ? 100 : 0;
        }
            
        // Upcoming Screenings (jadwal tayang yang belum berlalu)
        $this->upcomingScreenings = JadwalTayang::where('date', '>=', now()->toDateString())
            ->count();
            
        // Screenings minggu ini vs minggu lalu untuk persentase
        $currentWeekScreenings = JadwalTayang::whereBetween('date', [
                now()->startOfWeek()->toDateString(), 
                now()->endOfWeek()->toDateString()
            ])->count();
            
        $lastWeekScreenings = JadwalTayang::whereBetween('date', [
                now()->subWeek()->startOfWeek()->toDateString(), 
                now()->subWeek()->endOfWeek()->toDateString()
            ])->count();
            
        if ($lastWeekScreenings > 0) {
            $this->screeningsPercentChange = round((($currentWeekScreenings - $lastWeekScreenings) / $lastWeekScreenings) * 100, 1);
        } else {
            $this->screeningsPercentChange = $currentWeekScreenings > 0 ? 100 : 0;
        }
        
        // Recent Transactions
        $this->recentTransactions = Transaksi::with(['user', 'tikets.jadwalTayang.film'])
            ->orderBy('transaction_date', 'desc')
            ->take(10)
            ->get();
    }
    
    public function openTransactionModal($id) 
    {
        $this->selectedTransaction = Transaksi::with(['user', 'tikets.jadwalTayang.film'])
            ->findOrFail($id);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedTransaction = null;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
