<?php

namespace App\Livewire\User;

use App\Models\Transaksi;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

class Transactions extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.app')]
    
    public $search = '';
    public $statusFilter = 'all';
    public $sortField = 'transaction_date';
    public $sortDirection = 'desc';
    public $selectedTransaction = null;
    public $showTicketDetails = false;
    
    public function mount()
    {
        // Redirect if user is not authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingStatusFilter()
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
    
    public function viewTickets($transactionId)
    {
        $this->selectedTransaction = Transaksi::with(['tickets.kursi', 'tickets.jadwalTayang.film', 'tickets.jadwalTayang.studio'])
            ->findOrFail($transactionId);
        $this->showTicketDetails = true;
    }
    
    public function closeTicketDetails()
    {
        $this->showTicketDetails = false;
        $this->selectedTransaction = null;
    }
    
    public function downloadETicket($ticketId)
    {
        // This would typically generate a PDF e-ticket
        // For now, we'll just return a message
        session()->flash('info', 'E-ticket download functionality will be implemented soon');
        return;
    }
    
    public function cancelTransaction($transactionId)
    {
        $transaction = Transaksi::where('user_id', Auth::id())
            ->where('id', $transactionId)
            ->where('payment_status', 'pending')
            ->first();
        
        if ($transaction) {
            $transaction->update([
                'payment_status' => 'cancelled'
            ]);
            
            // Update related tickets
            $transaction->tickets()->update([
                'ticket_status' => 'Cancelled'
            ]);
            
            session()->flash('success', 'Transaction has been cancelled.');
        } else {
            session()->flash('error', 'Cannot cancel this transaction.');
        }
    }
    
    public function render()
    {
        $transactions = Transaksi::where('user_id', Auth::id())
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('booking_code', 'like', '%' . $this->search . '%')
                        ->orWhere('total_payment', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function (Builder $query) {
                $query->where('payment_status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
            
        $ticketCounts = Tiket::whereIn('transaksi_id', $transactions->pluck('id'))
            ->selectRaw('transaksi_id, count(*) as count')
            ->groupBy('transaksi_id')
            ->pluck('count', 'transaksi_id')
            ->toArray();
            
        return view('livewire.user.transactions', [
            'transactions' => $transactions,
            'ticketCounts' => $ticketCounts,
        ]);
    }
}
