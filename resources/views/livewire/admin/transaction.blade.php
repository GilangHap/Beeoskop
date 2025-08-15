<div class="py-4">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white">Transactions</h1>
                <p class="mt-1 text-sm text-gray-400">Manage and monitor all ticket transactions</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.verification') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-sm font-medium text-white hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Payment Verification
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
            
            <!-- Additional Filters -->
            <div class="flex flex-wrap items-center gap-4">
                <!-- Date Range Filter -->
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
                
                <!-- Status Filter -->
                <div class="w-full md:w-auto">
                    <label for="statusFilter" class="block text-xs text-gray-400 mb-1">Status</label>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" type="button" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg p-2.5 flex items-center justify-between w-full md:w-40">
                            <span>{{ $statusFilter ? $statuses[$statusFilter] : 'All Statuses' }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute left-0 mt-1 w-full bg-gray-800 border border-gray-700 rounded-lg shadow-lg z-10">
                            <ul class="py-1">
                                <li>
                                    <button wire:click="$set('statusFilter', '')" @click="open = false" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700 {{ !$statusFilter ? 'bg-primary/10 text-primary' : 'text-gray-300' }}">
                                        All Statuses
                                    </button>
                                </li>
                                @foreach($statuses as $value => $label)
                                    <li>
                                        <button wire:click="$set('statusFilter', '{{ $value }}')" @click="open = false" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700 {{ $statusFilter === $value ? 'bg-primary/10 text-primary' : 'text-gray-300' }}">
                                            {{ $label }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method Filter -->
                <div class="w-full md:w-auto">
                    <label for="paymentMethodFilter" class="block text-xs text-gray-400 mb-1">Payment Method</label>
                    <select 
                        id="paymentMethodFilter" 
                        wire:model.live="paymentMethodFilter" 
                        class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:border-primary block p-2 w-full md:w-40"
                    >
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Reset Filters -->
                <div class="w-full md:w-auto md:self-end">
                    <button 
                        type="button"
                        wire:click="$set('search', ''); $set('dateRange', 'last7days'); $set('statusFilter', ''); $set('paymentMethodFilter', '');"
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

    <!-- Transactions Table -->
    <div class="bg-dark border border-gray-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer" wire:click="sortBy('booking_code')">
                            <div class="flex items-center">
                                Booking Code
                                @if ($sortField === 'booking_code')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer" wire:click="sortBy('transaction_date')">
                            <div class="flex items-center">
                                Date
                                @if ($sortField === 'transaction_date')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer" wire:click="sortBy('total_payment')">
                            <div class="flex items-center">
                                Amount
                                @if ($sortField === 'total_payment')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Tickets
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Method
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-900/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                <span class="font-mono">{{ $transaction->booking_code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="flex flex-col">
                                    <span>{{ $transaction->transaction_date->format('M d, Y') }}</span>
                                    <span class="text-xs text-gray-500">{{ $transaction->transaction_date->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-col">
                                    <span class="text-white font-medium">{{ $transaction->user->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $transaction->user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary">
                                Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $transaction->tikets_count }} tickets</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $transaction->payment_method }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->payment_status === 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">
                                        Pending
                                    </span>
                                @elseif($transaction->payment_status === 'Success')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                        Success
                                    </span>
                                @elseif($transaction->payment_status === 'Failed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                        Failed
                                    </span>
                                @elseif($transaction->payment_status === 'Canceled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                        Canceled
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                                        {{ $transaction->payment_status }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- View Details Button -->
                                    <button 
                                        wire:click="viewDetails({{ $transaction->id }})" 
                                        class="text-gray-400 hover:text-primary transition-colors"
                                        title="View Details"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Status Update Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button 
                                            @click="open = !open"
                                            class="text-blue-400 hover:text-blue-300 transition-colors"
                                            title="Update Status"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div 
                                            x-show="open" 
                                            @click.away="open = false"
                                            class="absolute right-0 mt-2 w-48 bg-dark border border-gray-700 rounded-md shadow-lg z-10"
                                        >
                                            <div class="py-1">
                                                <button 
                                                    wire:click="updateStatus({{ $transaction->id }}, 'Pending')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-yellow-400 hover:bg-gray-800"
                                                >
                                                    Mark as Pending
                                                </button>
                                                <button 
                                                    wire:click="updateStatus({{ $transaction->id }}, 'Success')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-green-400 hover:bg-gray-800"
                                                >
                                                    Mark as Success
                                                </button>
                                                <button 
                                                    wire:click="updateStatus({{ $transaction->id }}, 'Failed')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800"
                                                >
                                                    Mark as Failed
                                                </button>
                                                <button 
                                                    wire:click="updateStatus({{ $transaction->id }}, 'Canceled')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-400 hover:bg-gray-800"
                                                >
                                                    Mark as Canceled
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-lg font-medium">No transactions found</span>
                                    <p class="mt-1 text-sm">Try adjusting your search criteria or date range</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($transactions->hasPages())
            <div class="px-6 py-3 border-t border-gray-800">
                {{ $transactions->links('livewire.custom-pagination') }}
            </div>
        @endif
    </div>
    
    <!-- Transaction Detail Modal -->
    <div x-data="{ show: @entangle('viewMode') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                @click="$wire.closeDetailModal()"
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
                                Transaction Details
                            </h3>
                            <button wire:click="closeDetailModal" class="text-gray-400 hover:text-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Transaction Header -->
                        <div class="bg-gray-800/50 rounded-lg p-4 mb-5 border border-gray-800">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-400">Booking Code:</span>
                                        <span class="ml-2 text-sm text-white font-mono">{{ $selectedTransaction->booking_code }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-lg font-bold text-white">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-3 md:mt-0">
                                    @if($selectedTransaction->payment_status === 'Pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">
                                            Pending
                                        </span>
                                    @elseif($selectedTransaction->payment_status === 'Success')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                            Success
                                        </span>
                                    @elseif($selectedTransaction->payment_status === 'Failed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                            Failed
                                        </span>
                                    @elseif($selectedTransaction->payment_status === 'Canceled')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400">
                                            Canceled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                                            {{ $selectedTransaction->payment_status }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Transaction Details -->
                            <div>
                                <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Transaction Information</h4>
                                <div class="bg-gray-800/50 rounded-lg border border-gray-800 overflow-hidden">
                                    <ul class="divide-y divide-gray-800">
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Date</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->transaction_date->format('M d, Y h:i A') }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Payment Method</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->payment_method }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Total Amount</span>
                                            <span class="text-sm font-medium text-primary">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Tickets</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->tikets->count() }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Customer Details -->
                            <div>
                                <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Customer Information</h4>
                                <div class="bg-gray-800/50 rounded-lg border border-gray-800 overflow-hidden">
                                    <ul class="divide-y divide-gray-800">
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Name</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->user->name }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Email</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->user->email }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Phone</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->user->phone ?? 'N/A' }}</span>
                                        </li>
                                        <li class="flex justify-between px-4 py-3">
                                            <span class="text-sm text-gray-400">Username</span>
                                            <span class="text-sm text-white">{{ $selectedTransaction->user->username }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Ticket Details -->
                        <div class="mt-5">
                            <h4 class="text-sm text-gray-400 uppercase tracking-wider mb-2">Tickets</h4>
                            <div class="bg-gray-800/50 rounded-lg border border-gray-800 overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-800">
                                        <thead class="bg-gray-900/50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                    Movie
                                                </th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                    Theater
                                                </th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                    Seat
                                                </th>
                                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                    Date & Time
                                                </th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                                    Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-800">
                                            @foreach($selectedTransaction->tikets as $ticket)
                                                <tr>
                                                    <td class="px-4 py-3 text-sm font-medium text-white">
                                                        {{ $ticket->jadwalTayang->film->title ?? 'Unknown Film' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-300">
                                                        Studio {{ $ticket->kursi->studio->name ?? 'Unknown' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-300">
                                                        {{ $ticket->kursi->chair_number ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-300">
                                                        <div class="flex flex-col">
                                                            <span>{{ \Carbon\Carbon::parse($ticket->jadwalTayang->date)->format('M d, Y') }}</span>
                                                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ticket->jadwalTayang->time_start)->format('h:i A') }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-right font-medium text-primary">
                                                        Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-900/20">
                                            <tr>
                                                <td colspan="4" class="px-4 py-3 text-sm font-medium text-right text-gray-400">
                                                    Total
                                                </td>
                                                <td class="px-4 py-3 text-sm text-right font-bold text-primary">
                                                    Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <!-- Actions -->
                        <div class="mt-6 flex justify-between">
                            <div class="flex space-x-2">
                            </div>
                            <div class="flex space-x-2">
                                @if($selectedTransaction->payment_status === 'Pending')
                                    <button 
                                        type="button"
                                        wire:click="updateStatus({{ $selectedTransaction->id }}, 'Success')" 
                                        class="px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors focus:outline-none"
                                    >
                                        Mark as Success
                                    </button>
                                    
                                    <button 
                                        type="button"
                                        wire:click="updateStatus({{ $selectedTransaction->id }}, 'Failed')" 
                                        class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none"
                                    >
                                        Mark as Failed
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Toast Notification -->
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        @showAlert.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => { show = false }, 3000)"
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50"
    >
        <div class="max-w-sm w-full bg-dark border border-gray-700 rounded-lg shadow-lg pointer-events-auto">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <template x-if="type === 'success'">
                            <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </template>
                        <template x-if="type === 'error'">
                            <div class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p x-text="message" class="text-sm font-medium text-white"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-gray-400 hover:text-gray-300">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>