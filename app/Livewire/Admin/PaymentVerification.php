<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Transaksi;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentVerification extends Component
{
    use WithPagination, WithFileUploads;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Filtering properties
    public $search = '';
    public $dateRange = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    
    // Modal properties
    public $selectedTransaction = null;
    public $isViewModalOpen = false;
    public $note = ''; // For admin notes when rejecting/cancelling
    
    // Date range options
    public $dateRangeOptions = [
        'today' => 'Today',
        'yesterday' => 'Yesterday',
        'last7days' => 'Last 7 days',
        'thisMonth' => 'This month',
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
    
    public function viewPaymentProof($id)
    {
        $this->selectedTransaction = Transaksi::with(['user', 'tikets.jadwalTayang.film'])
            ->findOrFail($id);
            
        $this->isViewModalOpen = true;
        $this->note = ''; // Reset note field
    }
    
    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedTransaction = null;
        $this->note = '';
    }
    
    public function verifyPayment()
    {
        if (!$this->selectedTransaction) {
            return;
        }
        
        $this->selectedTransaction->payment_status = 'Success';
        $this->selectedTransaction->save();
        
        // You may want to trigger notifications to user here
        
        $this->dispatch('showAlert', [
            'message' => 'Payment verified successfully',
            'type' => 'success'
        ]);
        
        $this->closeViewModal();
    }
    
    public function rejectPayment()
    {
        if (!$this->selectedTransaction) {
            return;
        }
        
        $this->selectedTransaction->payment_status = 'Failed';
        $this->selectedTransaction->save();
        
        // You may want to trigger notifications to user here
        
        $this->dispatch('showAlert', [
            'message' => 'Payment rejected',
            'type' => 'success'
        ]);
        
        $this->closeViewModal();
    }
    
    public function cancelPayment()
    {
        if (!$this->selectedTransaction) {
            return;
        }
        
        $this->selectedTransaction->payment_status = 'Canceled';
        $this->selectedTransaction->save();
        
        $this->dispatch('showAlert', [
            'message' => 'Payment has been canceled',
            'type' => 'success'
        ]);
        
        $this->closeViewModal();
    }
    
    public function requestNewProof()
    {
        if (!$this->selectedTransaction) {
            return;
        }
    
        $this->selectedTransaction->payment_status = 'Pending';
        $this->selectedTransaction->save();
        
        // You may want to trigger notifications to user here
        
        $this->dispatch('showAlert', [
            'message' => 'New payment proof requested',
            'type' => 'success'
        ]);
        
        $this->closeViewModal();
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
                
            case 'thisMonth':
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
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
        
        // Ambil data transaksi dengan status Pending
        // Simplifikasi query untuk mengurangi kemungkinan error
        $query = Transaksi::with(['user'])
            ->where('payment_status', 'Pending');
        
        // Tambahkan pencarian jika ada
        if ($this->search) {
            $query->where(function($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        // Tambahkan filter tanggal jika tersedia
        if ($dateRange['start'] && $dateRange['end']) {
            $query->whereDate('transaction_date', '>=', $dateRange['start'])
                  ->whereDate('transaction_date', '<=', $dateRange['end']);
        }
        
        // Selesaikan query
        $pendingPayments = $query->withCount('tikets')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
            
        return view('livewire.admin.payment-verification', [
            'pendingPayments' => $pendingPayments
        ]);
    }
}
