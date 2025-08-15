<div class="py-4">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white">Payment Verification</h1>
                <p class="mt-1 text-sm text-gray-400">Review and verify customer payment proofs</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.transactions') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm font-medium text-white hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                        </svg>
                        All Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters and Search Area -->
    <div class="bg-dark border border-gray-800 rounded-xl p-4 mb-6">
        <div class="flex flex-col space-y-4">
            <!-- Search and Per Page -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        wire:model.live.debounce.300ms="search" 
                        class="pl-10 pr-4 py-2 w-full md:w-80 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="Search by booking code, name or email..."
                    />
                </div>
                
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <label for="perPage" class="text-sm text-gray-400">Show:</label>
                        <select 
                            id="perPage" 
                            wire:model.live="perPage" 
                            class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:border-primary block p-2"
                        >
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Date Range Filter -->
            <div class="flex flex-wrap items-center gap-4">
                <div class="w-full md:w-auto">
                    <label for="dateRange" class="block text-xs text-gray-400 mb-1">Date Range</label>
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open"
                            type="button"
                            class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:border-primary p-2 w-full md:w-48 flex items-center justify-between"
                        >
                            <span>{{ $dateRangeOptions[$dateRange] ?? 'Select range' }}</span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            class="absolute left-0 mt-1 w-full bg-gray-800 border border-gray-700 rounded-lg shadow-lg z-10"
                        >
                            <ul class="py-1">
                                @foreach($dateRangeOptions as $value => $label)
                                    <li>
                                        <button 
                                            type="button"
                                            wire:click="$set('dateRange', '{{ $value }}')"
                                            @click="open = false"
                                            class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700 {{ $dateRange === $value ? 'bg-primary/10 text-primary' : 'text-gray-300' }}"
                                        >
                                            {{ $label }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            
                            @if($dateRange === 'custom')
                                <div class="px-3 py-2 border-t border-gray-700">
                                    <div class="mb-2">
                                        <label class="block text-xs text-gray-400 mb-1">From</label>
                                        <input 
                                            type="date" 
                                            wire:model.live="customDateStart"
                                            class="w-full bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:border-primary block p-2"
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-400 mb-1">To</label>
                                        <input 
                                            type="date" 
                                            wire:model.live="customDateEnd"
                                            class="w-full bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:border-primary block p-2"
                                        />
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Reset Filters -->
                <div class="w-full md:w-auto md:self-end">
                    <button 
                        type="button"
                        wire:click="$set('search', ''); $set('dateRange', 'last7days');"
                        class="text-gray-400 hover:text-white text-sm flex items-center p-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Reset filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Queue Heading -->
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
            </svg>
            Verification Queue
            <span class="ml-2 px-2 py-1 bg-primary/20 text-primary text-xs font-bold rounded-full">
                {{ $pendingPayments->total() }}
            </span>
        </h2>
        <span class="text-sm text-gray-400">
            Showing payments awaiting verification
        </span>
    </div>

    <!-- Payment Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($pendingPayments as $transaction)
            <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden transition-transform hover:scale-[1.02] hover:shadow-lg hover:shadow-primary/5">
                <!-- Card Header -->
                <div class="p-4 border-b border-gray-800 flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white truncate max-w-[120px]">{{ $transaction->user->name }}</p>
                                <p class="text-xs text-gray-400 truncate max-w-[120px]">{{ $transaction->user->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ getStatusBadgeClasses($transaction->payment_status) }}">
                            {{ $transaction->payment_status }}
                        </span>
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs text-gray-400">Booking Code</div>
                        <div class="text-sm font-mono font-medium text-white">{{ $transaction->booking_code }}</div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs text-gray-400">Date</div>
                        <div class="text-sm text-white">{{ $transaction->transaction_date->format('M d, Y - H:i') }}</div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs text-gray-400">Amount</div>
                        <div class="text-sm font-medium text-primary">Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}</div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-400">Payment Method</div>
                        <div class="text-sm text-white">{{ $transaction->payment_method }}</div>
                    </div>
                    
                    <!-- Payment Proof Thumbnail (if available) -->
                    @if($transaction->payment_proof)
                        <div class="mt-4 rounded-lg overflow-hidden">
                            <img 
                                src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                                alt="Payment Proof" 
                                class="w-full h-32 object-cover hover:opacity-90 transition-opacity cursor-pointer"
                                wire:click="viewPaymentProof({{ $transaction->id }})"
                            >
                        </div>
                    @endif
                </div>
                
                <!-- Card Actions -->
                <div class="p-4 border-t border-gray-800">
                    <button 
                        wire:click="viewPaymentProof({{ $transaction->id }})" 
                        class="w-full py-2 bg-primary hover:bg-amber-400 text-black font-medium rounded-lg transition-colors"
                    >
                        Verify Payment
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-dark/60 border border-gray-800 rounded-xl p-8 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Payments to Verify</h3>
                    <p class="text-gray-400 max-w-sm">
                        All payments have been verified. Check back later or view all transactions to see the complete history.
                    </p>
                    <a 
                        href="{{ route('admin.transactions') }}" wire:navigate
                        class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm font-medium text-white hover:bg-gray-700"
                    >
                        View All Transactions
                    </a>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if ($pendingPayments->hasPages())
        <div class="mt-6">
            {{ $pendingPayments->links('livewire.custom-pagination') }}
        </div>
    @endif
    
    <!-- Payment Verification Modal -->
    <div x-data="{ show: @entangle('isViewModalOpen') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div 
                x-show="show" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                aria-hidden="true"
                @click="$wire.closeViewModal()"
            ></div>

            <!-- Modal panel -->
            <div 
                x-show="show" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-3xl transform transition-all mx-auto"
            >
                @if($selectedTransaction)
                    <div class="px-6 pt-5 pb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-white">
                                Payment Verification
                            </h3>
                            <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column - Transaction Info -->
                            <div>
                                <div class="mb-5">
                                    <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Transaction Details</h4>
                                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-800">
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-sm text-gray-400">Booking Code:</span>
                                            <span class="text-sm font-mono text-white">{{ $selectedTransaction->booking_code }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-sm text-gray-400">Date:</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->transaction_date->format('M d, Y - H:i') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-sm text-gray-400">Payment Method:</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->payment_method }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-400">Amount:</span>
                                            <span class="text-sm font-medium text-primary">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-5">
                                    <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Customer Information</h4>
                                    <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-800">
                                        <div class="flex items-center mb-3">
                                            <div class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center mr-3">
                                                {{ strtoupper(substr($selectedTransaction->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $selectedTransaction->user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $selectedTransaction->user->email }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-sm text-gray-400">Phone:</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->user->phone ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Ticket Details</h4>
                                    <div class="bg-gray-800/50 rounded-lg border border-gray-800">
                                        <div class="overflow-y-auto max-h-36">
                                            <ul class="divide-y divide-gray-800">
                                                @foreach($selectedTransaction->tikets as $ticket)
                                                    <li class="p-3">
                                                        <div class="text-sm text-white">
                                                            {{ $ticket->jadwalTayang->film->title ?? 'Unknown Film' }}
                                                        </div>
                                                        <div class="flex justify-between mt-1">
                                                            <span class="text-xs text-gray-400">
                                                                {{ \Carbon\Carbon::parse($ticket->jadwalTayang->date)->format('M d, Y') }} - 
                                                                {{ \Carbon\Carbon::parse($ticket->jadwalTayang->time_start)->format('H:i') }}
                                                            </span>
                                                            <span class="text-xs text-primary">
                                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="p-3 border-t border-gray-800 flex justify-between">
                                            <span class="text-sm font-medium text-gray-400">Total:</span>
                                            <span class="text-sm font-medium text-primary">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column - Payment Proof and Actions -->
                            <div>
                                <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Payment Proof</h4>
                                
                                @if($selectedTransaction->payment_proof)
                                    <div class="mb-4 bg-gray-800/50 rounded-lg overflow-hidden border border-gray-800">
                                        <img 
                                            src="{{ asset('storage/' . $selectedTransaction->payment_proof) }}" 
                                            alt="Payment Proof" 
                                            class="w-full object-contain max-h-80"
                                        >
                                    </div>
                                @else
                                    <div class="mb-4 bg-gray-800/50 rounded-lg p-8 border border-gray-800 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-gray-400">No payment proof uploaded</p>
                                    </div>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-col space-y-3">
                                    <button 
                                        wire:click="verifyPayment" 
                                        class="py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Approve Payment
                                    </button>
                                    
                                    <button 
                                        wire:click="requestNewProof" 
                                        class="py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                    </svg>
                                    Request New Proof
                                </button>
                                
                                    <button 
                                        wire:click="rejectPayment" 
                                        class="py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors flex items-center justify-center"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status badge color helper - add this to a shared component or helper file -->
@php
function getStatusBadgeClasses($status) {
    switch ($status) {
        case 'Success':
            return 'bg-green-500/20 text-green-400';
        case 'Pending':
            return 'bg-yellow-500/20 text-yellow-400';
        case 'Failed':
            return 'bg-red-500/20 text-red-400';
        case 'Canceled':
            return 'bg-gray-500/20 text-gray-400';
        default:
            return 'bg-blue-500/20 text-blue-400';
    }
}
@endphp
