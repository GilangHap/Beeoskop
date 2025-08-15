<div>
    <!-- Hero Header Section -->
    <div class="relative bg-gray-900 mb-8 overflow-hidden">
        <div class="absolute inset-0">
            <div class="bg-gradient-to-b from-gray-900/70 to-gray-900"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary/20 via-gray-900/0 to-gray-900/0"></div>
        </div>
        
        <div class="container relative mx-auto px-4 md:px-6 py-12">
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">My Transactions</h1>
                <p class="text-gray-300 max-w-2xl">
                    View and manage your movie ticket bookings and transactions history
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 md:px-6 pb-16">
        <!-- Search and Filter Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gray-800/50 p-4 rounded-xl border border-gray-700/50 mb-6 backdrop-blur-sm">
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-primary/20 flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="text-white font-medium">{{ $transactions->total() }} Transactions</span>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3 md:w-auto w-full">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by booking code..."
                        class="bg-dark border border-gray-700 rounded-lg py-2 px-4 pr-10 text-white w-full focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/30 transition-all"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                
                <select
                    wire:model.live="statusFilter"
                    class="bg-dark border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/30 transition-all"
                >
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="refunded">Refunded</option>
                </select>
            </div>
        </div>
        
        <!-- Alert Messages - Improved styling -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-900/20 border border-green-600/30 rounded-lg text-green-400 flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-900/20 border border-red-600/30 rounded-lg text-red-400 flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if (session()->has('info'))
            <div class="mb-6 p-4 bg-blue-900/20 border border-blue-600/30 rounded-lg text-blue-400 flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('info') }}</span>
            </div>
        @endif
        
        <!-- Transactions Table - Improved -->
        <div class="bg-dark border border-gray-800 rounded-xl overflow-hidden shadow-lg">
            @if($transactions->isEmpty())
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-800/70 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-medium text-white mb-2">No Transactions Found</h2>
                    <p class="text-gray-400 mb-6 max-w-md mx-auto">You haven't made any bookings yet. Browse our movies and book your next cinema experience!</p>
                    <a href="{{ route('movies') }}" wire:navigate class="inline-flex items-center px-6 py-2.5 bg-primary hover:bg-yellow-400 text-black font-medium rounded-lg transition group">
                        Browse Movies
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="overflow-hidden">
                    <table class="w-full text-left table-fixed">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[25%]">
                                    <button wire:click="sortBy('booking_code')" class="flex items-center focus:outline-none group">
                                        Booking Code
                                        <span class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if ($sortField === 'booking_code')
                                                @if ($sortDirection === 'asc')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                @endif
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            @endif
                                        </span>
                                    </button>
                                </th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[20%]">
                                    <button wire:click="sortBy('transaction_date')" class="flex items-center focus:outline-none group">
                                        Date
                                        <span class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if ($sortField === 'transaction_date')
                                                @if ($sortDirection === 'asc')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                @endif
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            @endif
                                        </span>
                                    </button>
                                </th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[15%]">
                                    Amount
                                </th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[15%]">
                                    <button wire:click="sortBy('payment_status')" class="flex items-center focus:outline-none group">
                                        Status
                                        <span class="ml-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @if ($sortField === 'payment_status')
                                                @if ($sortDirection === 'asc')
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                @endif
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            @endif
                                        </span>
                                    </button>
                                </th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[10%]">
                                    Tickets
                                </th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-300 uppercase tracking-wider w-[15%] text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $index => $transaction)
                                <tr class="hover:bg-gray-800/50 {{ $index % 2 === 0 ? 'bg-gray-900/30' : 'bg-transparent' }} transition-colors">
                                    <td class="px-6 py-4 truncate">
                                        <div class="font-mono font-medium text-white tracking-wide">{{ $transaction->booking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        <div class="text-sm text-white">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        <div class="text-sm font-medium">
                                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-yellow-400">
                                                Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        @if($transaction->payment_status == 'Success')
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 rounded-full bg-green-400 mr-2"></div>
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-900/30 text-green-400 border border-green-600/20">
                                                    Confirmed
                                                </span>
                                            </div>
                                        @elseif($transaction->payment_status == 'Pending')
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 rounded-full bg-yellow-400 mr-2"></div>
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-900/30 text-yellow-400 border border-yellow-600/20">
                                                    Pending
                                                </span>
                                            </div>
                                        @elseif($transaction->payment_status == 'Cancelled')
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 rounded-full bg-red-400 mr-2"></div>
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-900/30 text-red-400 border border-red-600/20">
                                                    Cancelled
                                                </span>
                                            </div>
                                        @elseif($transaction->payment_status == 'Failed')
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 rounded-full bg-blue-400 mr-2"></div>
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-900/30 text-blue-400 border border-blue-600/20">
                                                    Failed
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <div class="h-2 w-2 rounded-full bg-gray-400 mr-2"></div>
                                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-900/30 text-gray-400 border border-gray-600/20">
                                                    {{ ucfirst($transaction->payment_status) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 truncate">
                                        <div class="text-sm text-white">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                </svg>
                                                <span>{{ $ticketCounts[$transaction->id] ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 truncate text-right">
                                        <div class="flex items-center justify-end">
                                            <button 
                                                wire:click="viewTickets({{ $transaction->id }})" 
                                                class="text-primary hover:text-yellow-400 transition-colors flex items-center ml-auto"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Details
                                            </button>
                                            
                                            @if($transaction->payment_status == 'pending')
                                                <button 
                                                    wire:click="cancelTransaction({{ $transaction->id }})"
                                                    wire:confirm="Are you sure you want to cancel this transaction?"
                                                    class="text-red-400 hover:text-red-300 transition-colors flex items-center ml-3"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Cancel
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination - Improved -->
                <div class="px-6 py-4 bg-gray-800/70 border-t border-gray-700/30">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
    
    <!-- Modal Detail Tiket - Improved -->
    @if($showTicketDetails && $selectedTransaction)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                
                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-gray-900 rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full animate-fade-in-up">
                    <div class="bg-gradient-to-b from-gray-800 to-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-700/50">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <div class="flex justify-between items-center mb-5">
                                    <h3 class="text-lg md:text-xl leading-6 font-semibold text-white flex items-center" id="modal-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Transaction Details
                                    </h3>
                                    <button wire:click="closeTicketDetails" class="text-gray-400 hover:text-white transition-colors rounded-full p-1 hover:bg-gray-700/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="bg-gray-800/70 rounded-lg p-5 mb-5 backdrop-blur-sm border border-gray-700/50">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-400">Booking Code</p>
                                            <div class="flex items-center">
                                                <p class="text-lg font-mono font-bold text-primary">{{ $selectedTransaction->booking_code }}</p>
                                                <button 
                                                    onclick="copyToClipboard('{{ $selectedTransaction->booking_code }}')"
                                                    class="ml-2 text-gray-500 hover:text-gray-300"
                                                    title="Copy to clipboard"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-2M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-400">Status</p>
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full 
                                                    @if($selectedTransaction->payment_status == 'Success') bg-green-400
                                                    @elseif($selectedTransaction->payment_status == 'Pending') bg-yellow-400
                                                    @elseif($selectedTransaction->payment_status == 'Cancelled') bg-red-400
                                                    @elseif($selectedTransaction->payment_status == 'Failed') bg-blue-400
                                                    @else bg-gray-400 @endif
                                                    mr-2"></div>
                                                <p class="text-base font-medium 
                                                    @if($selectedTransaction->payment_status == 'Success') text-green-400
                                                    @elseif($selectedTransaction->payment_status == 'Pending') text-yellow-400
                                                    @elseif($selectedTransaction->payment_status == 'Cancelled') text-red-400
                                                    @elseif($selectedTransaction->payment_status == 'Failed') text-blue-400
                                                    @else text-gray-300 @endif">
                                                    {{ ucfirst($selectedTransaction->payment_status) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-400">Transaction Date</p>
                                            <p class="text-white flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($selectedTransaction->transaction_date)->format('d M Y H:i') }}
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-400">Total Amount</p>
                                            <p class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-yellow-400">
                                                Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4 flex justify-between items-center">
                                    <h4 class="font-medium text-white flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                        Tickets ({{ count($selectedTransaction->tickets) }})
                                    </h4>
                                    @if($selectedTransaction->payment_status == 'confirmed')
                                        <button class="text-xs px-3 py-1 bg-primary/20 hover:bg-primary/30 text-primary rounded-full transition flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download All
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                                    @foreach($selectedTransaction->tickets as $ticket)
                                        <div class="bg-gray-800/70 backdrop-blur-sm rounded-lg p-4 border border-gray-700/50 hover:border-gray-600/50 transition-all">
                                            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                                                <div class="mb-4 md:mb-0 md:pr-4">
                                                    <div class="flex items-start mb-1.5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-1.5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                                        </svg>
                                                        <h5 class="text-lg font-medium text-white">{{ $ticket->jadwalTayang->film->title }}</h5>
                                                    </div>
                                                    
                                                    <div class="ml-6.5 space-y-1">
                                                        <p class="text-gray-400 flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($ticket->jadwalTayang->date)->format('l, d M Y') }}
                                                        </p>
                                                        <p class="text-gray-400 flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($ticket->jadwalTayang->time_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($ticket->jadwalTayang->time_end)->format('H:i') }}
                                                        </p>
                                                        <p class="text-gray-400 flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                            </svg>
                                                            Studio {{ $ticket->jadwalTayang->studio->name }}
                                                        </p>
                                                        <p class="text-white font-medium flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Seat {{ $ticket->kursi->chair_number }}
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex flex-col items-end space-y-3">
                                                    <span class="text-sm px-2.5 py-1 rounded-full
                                                        @if($ticket->ticket_status == 'Confirmed') bg-green-900/50 text-green-400 border border-green-700/30
                                                        @elseif($ticket->ticket_status == 'Reserved') bg-yellow-900/50 text-yellow-400 border border-yellow-700/30
                                                        @elseif($ticket->ticket_status == 'Cancelled') bg-red-900/50 text-red-400 border border-red-700/30
                                                        @else bg-gray-900/50 text-gray-400 border border-gray-700/30 @endif">
                                                        {{ $ticket->ticket_status }}
                                                    </span>
                                                    
                                                    @if($ticket->ticket_status == 'Confirmed')
                                                        <button 
                                                            wire:click="downloadETicket({{ $ticket->id }})"
                                                            class="px-3 py-1.5 bg-primary hover:bg-yellow-400 text-black text-sm rounded-lg font-medium transition flex items-center"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            E-Ticket
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($selectedTransaction->payment_status == 'pending')
                                    <div class="mt-5 p-4 bg-yellow-900/20 border border-yellow-700/30 rounded-lg text-yellow-400 text-sm flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>Your payment is being verified by our team. This usually takes 1-2 business days. You will receive an email notification once your tickets are confirmed.</p>
                                    </div>
                                @endif
                                
                                @if($selectedTransaction->payment_status == 'cancelled')
                                    <div class="mt-5 p-4 bg-red-900/20 border border-red-700/30 rounded-lg text-red-400 text-sm flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p>This transaction has been cancelled. The seats have been released and are available for booking again.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800/70 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700/50">
                        <button 
                            wire:click="closeTicketDetails" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-primary transition-all sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Close
                        </button>
                        
                        @if($selectedTransaction->payment_status == 'pending')
                            <button 
                                wire:click="cancelTransaction({{ $selectedTransaction->id }})"
                                wire:confirm="Are you sure you want to cancel this transaction? This action cannot be undone."
                                type="button" 
                                class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-lg border border-red-800 shadow-sm px-4 py-2 bg-red-900/30 text-base font-medium text-red-400 hover:bg-red-900/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-red-500 transition-all sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Transaction
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Overlay close on click -->
        <div class="fixed inset-0 z-40" wire:click="closeTicketDetails"></div>
    @endif
    
    <!-- Script untuk interaksi dan efek -->
    <script>
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('closeModal', function() {
                document.body.classList.remove('overflow-hidden');
            });
            
            Livewire.on('openModal', function() {
                document.body.classList.add('overflow-hidden');
            });
            
            // Animasi pada baris table saat hover
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseover', () => {
                    row.classList.add('scale-[1.01]', 'shadow-lg');
                    row.style.zIndex = '10';
                    row.style.transition = 'all 0.2s ease';
                });
                
                row.addEventListener('mouseout', () => {
                    row.classList.remove('scale-[1.01]', 'shadow-lg');
                    row.style.zIndex = '1';
                });
            });
        });
        
        // Fungsi untuk menyalin teks ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    // Tampilkan notifikasi
                    const notification = document.createElement('div');
                    notification.textContent = 'Copied to clipboard!';
                    notification.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
                    document.body.appendChild(notification);
                    
                    // Hilangkan notifikasi setelah 2 detik
                    setTimeout(() => {
                        notification.classList.add('animate-fade-out');
                        setTimeout(() => {
                            document.body.removeChild(notification);
                        }, 300);
                    }, 2000);
                })
                .catch(err => console.error('Failed to copy: ', err));
        }
        
        // Tambahkan animasi untuk elemen yang muncul
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate-fade-in-up');
            elements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>

    <style>
        /* Style tambahan untuk scroll dan animasi */
        .max-h-96 {
            scrollbar-width: thin;
            scrollbar-color: rgba(201, 161, 22, 0.5) rgba(31, 41, 55, 0.5);
        }
        
        .max-h-96::-webkit-scrollbar {
            width: 8px;
        }
        
        .max-h-96::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.5);
            border-radius: 4px;
        }
        
        .max-h-96::-webkit-scrollbar-thumb {
            background-color: rgba(201, 161, 22, 0.5);
            border-radius: 4px;
            border: 2px solid rgba(31, 41, 55, 0.5);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</div>