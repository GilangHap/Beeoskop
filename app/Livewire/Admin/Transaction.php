<?php

namespace App\Livewire\Admin;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class Transaction extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Filtering and sorting properties
    public $search = '';
    public $dateRange = '';
    public $statusFilter = '';
    public $paymentMethodFilter = '';
    public $sortField = 'transaction_date';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // Modal properties
    public $selectedTransaction = null;
    public $viewMode = false;
    
    // Date range options
    public $dateRangeOptions = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last7days' => 'Last 7 days',
        'last30days' => 'Last 30 days', 
        'thisMonth' => 'This month',
        'lastMonth' => 'Last month',
        'custom' => 'Custom range',
    ];
    
    // Custom date range fields
    public $customDateStart = '';
    public $customDateEnd = '';
    
    public function mount()
    {
        // Set default date range to last 7 days
        $this->dateRange = 'last7days';
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    
    public function updatingPaymentMethodFilter()
    {
        $this->resetPage();
    }
    
    public function updatingDateRange()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function viewDetails($id)
    {
        $transaction = Transaksi::with(['user', 'tikets.jadwalTayang.film', 'tikets.kursi.studio'])
            ->findOrFail($id);
            
        $this->selectedTransaction = $transaction;
        $this->viewMode = true;
    }
    
    public function closeDetailModal()
    {
        $this->selectedTransaction = null;
        $this->viewMode = false;
    }
    
    public function updateStatus($id, $status)
    {
        // Validasi status yang diizinkan
        $allowedStatuses = ['Pending', 'Success', 'Failed', 'Canceled'];
        
        if (!in_array($status, $allowedStatuses)) {
            $this->dispatch('showAlert', [
                'message' => "Invalid status value",
                'type' => 'error'
            ]);
            return;
        }
        
        $transaction = Transaksi::findOrFail($id);
        $transaction->payment_status = $status;
        $transaction->save();
        
        $this->dispatch('showAlert', [
            'message' => "Transaction status updated to {$status}",
            'type' => 'success'
        ]);
        
        if ($this->selectedTransaction && $this->selectedTransaction->id === $id) {
            $this->selectedTransaction->payment_status = $status;
        }
    }
    
    public function getDateRangeValues()
    {
        $today = Carbon::today();
        $startDate = null;
        $endDate = null;
        
        switch ($this->dateRange) {
            case 'today':
                $startDate = $today->copy();
                $endDate = $today->copy();
                break;
                
            case 'yesterday':
                $startDate = $today->copy()->subDay();
                $endDate = $today->copy()->subDay();
                break;
                
            case 'last7days':
                $startDate = $today->copy()->subDays(6);
                $endDate = $today->copy();
                break;
                
            case 'last30days':
                $startDate = $today->copy()->subDays(29);
                $endDate = $today->copy();
                break;
                
            case 'thisMonth':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
                
            case 'lastMonth':
                $startDate = $today->copy()->subMonth()->startOfMonth();
                $endDate = $today->copy()->subMonth()->endOfMonth();
                break;
                
            case 'custom':
                if ($this->customDateStart && $this->customDateEnd) {
                    $startDate = Carbon::parse($this->customDateStart);
                    $endDate = Carbon::parse($this->customDateEnd)->endOfDay();
                }
                break;
        }
        
        return [
            'start' => $startDate,
            'end' => $endDate
        ];
    }
    
    public function render()
    {
        $dateRange = $this->getDateRangeValues();
        
        $query = Transaksi::with(['user', 'tikets']);
        
        // Pencarian berdasarkan booking code atau user
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        // Filter berdasarkan status
        if ($this->statusFilter) {
            $query->where('payment_status', $this->statusFilter);
        }
        
        // Filter berdasarkan metode pembayaran
        if ($this->paymentMethodFilter) {
            $query->where('payment_method', $this->paymentMethodFilter);
        }
        
        // Filter berdasarkan range tanggal
        if ($dateRange['start'] && $dateRange['end']) {
            $query->whereDate('transaction_date', '>=', $dateRange['start'])
                  ->whereDate('transaction_date', '<=', $dateRange['end']);
        }
        
        // Selesaikan query
        $transactions = $query->withCount('tikets')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        // Get distinct payment methods for filter
        $paymentMethods = Transaksi::distinct()
            ->orderBy('payment_method')
            ->pluck('payment_method')
            ->filter()
            ->toArray();
            
        // Sinkronkan status dengan komponen verifikasi pembayaran
        $statuses = [
            'Pending' => 'Pending',
            'Success' => 'Success',
            'Failed' => 'Failed', 
            'Canceled' => 'Canceled'
        ];
        
        return view('livewire.admin.transaction', [
            'transactions' => $transactions,
            'paymentMethods' => $paymentMethods,
            'statuses' => $statuses
        ]);
    }
}
