<div>
    <!-- Use the header named slot -->
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
    </div>
    

    <!-- Main content goes in the slot -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stats Card: Total Revenue -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-xs {{ $revenuePercentChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-2 flex items-center">
                        @if($revenuePercentChange >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        {{ abs($revenuePercentChange) }}% {{ $revenuePercentChange >= 0 ? 'increase' : 'decrease' }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Stats Card: Total Bookings -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Total Bookings</p>
                    <h3 class="text-2xl font-bold text-white">{{ number_format($totalBookings) }}</h3>
                    <p class="text-xs {{ $bookingsPercentChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-2 flex items-center">
                        @if($bookingsPercentChange >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                            </svg>
                        @endif
                        {{ abs($bookingsPercentChange) }}% {{ $bookingsPercentChange >= 0 ? 'increase' : 'decrease' }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Stats Card: Active Users -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Active Users</p>
                    <h3 class="text-2xl font-bold text-white">{{ number_format($activeUsers) }}</h3>
                    <p class="text-xs {{ $usersPercentChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-2 flex items-center">
                        @if($usersPercentChange >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                        @endif
                        {{ abs($usersPercentChange) }}% {{ $usersPercentChange >= 0 ? 'increase' : 'decrease' }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Stats Card: Upcoming Screenings -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Upcoming Screenings</p>
                    <h3 class="text-2xl font-bold text-white">{{ number_format($upcomingScreenings) }}</h3>
                    <p class="text-xs {{ $screeningsPercentChange >= 0 ? 'text-green-500' : 'text-red-500' }} mt-2 flex items-center">
                        @if($screeningsPercentChange >= 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
                        @endif
                        {{ abs($screeningsPercentChange) }}% {{ $screeningsPercentChange >= 0 ? 'increase' : 'decrease' }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="mt-8 bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-800">
            <h2 class="font-bold text-lg">Recent Transactions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Movie</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->booking_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->user->name ?? $transaction->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->tikets->isNotEmpty() && $transaction->tikets->first()->jadwalTayang && $transaction->tikets->first()->jadwalTayang->film)
                                    {{ $transaction->tikets->first()->jadwalTayang->film->title }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">Rp {{ number_format($transaction->total_payment, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClass = '';
                                    switch($transaction->payment_status) {
                                        case 'Success':
                                            $statusClass = 'bg-green-500/20 text-green-400';
                                            break;
                                        case 'Pending':
                                            $statusClass = 'bg-yellow-500/20 text-yellow-400';
                                            break;
                                        case 'Failed':
                                            $statusClass = 'bg-red-500/20 text-red-400';
                                            break;
                                        case 'Canceled':
                                            $statusClass = 'bg-gray-500/20 text-gray-400';
                                            break;
                                        default:
                                            $statusClass = 'bg-blue-500/20 text-blue-400';
                                    }
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ $transaction->payment_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button 
                                    wire:click="openTransactionModal({{ $transaction->id }})"
                                    class="text-primary hover:text-amber-400"
                                >
                                    View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-400">
                                No transactions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 flex justify-between items-center border-t border-gray-800">
            <a href="{{ route('admin.transactions') }}" wire:navigate class="text-primary hover:text-amber-400 text-sm">View All Transactions</a>
        </div>
    </div>

    <!-- Transaction Detail Modal -->
    @if($isModalOpen && $selectedTransaction)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="inline-block align-bottom bg-dark rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-dark px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start border-b border-gray-700 pb-3 mb-4">
                        <h3 class="text-lg font-medium text-white">
                            Transaction Details
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Transaction Info -->
                        <div class="bg-gray-800/40 rounded-lg p-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Booking Code:</span>
                                <span class="text-white font-medium">{{ $selectedTransaction->booking_code }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Date:</span>
                                <span class="text-white">{{ $selectedTransaction->transaction_date->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-400">Total Amount:</span>
                                <span class="text-white font-bold">Rp {{ number_format($selectedTransaction->total_payment, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status:</span>
                                @php
                                    $statusClass = '';
                                    switch($selectedTransaction->payment_status) {
                                        case 'Success':
                                            $statusClass = 'bg-green-500/20 text-green-400';
                                            break;
                                        case 'Pending':
                                            $statusClass = 'bg-yellow-500/20 text-yellow-400';
                                            break;
                                        case 'Failed':
                                            $statusClass = 'bg-red-500/20 text-red-400';
                                            break;
                                        case 'Canceled':
                                            $statusClass = 'bg-gray-500/20 text-gray-400';
                                            break;
                                        default:
                                            $statusClass = 'bg-blue-500/20 text-blue-400';
                                    }
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ $selectedTransaction->payment_status }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Customer Info -->
                        <div>
                            <h4 class="text-white font-medium mb-2">Customer Details</h4>
                            <div class="bg-gray-800/40 rounded-lg p-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-400">Name:</span>
                                    <span class="text-white">{{ $selectedTransaction->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Email:</span>
                                    <span class="text-white">{{ $selectedTransaction->user->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tickets -->
                        <div>
                            <h4 class="text-white font-medium mb-2">Tickets</h4>
                            <div class="bg-gray-800/40 rounded-lg p-4">
                                @if($selectedTransaction->tikets->isNotEmpty())
                                    @foreach($selectedTransaction->tikets as $ticket)
                                        <div class="mb-3 pb-3 {{ !$loop->last ? 'border-b border-gray-700' : '' }}">
                                            <div class="flex justify-between mb-1">
                                                <span class="text-white">{{ $ticket->jadwalTayang->film->title ?? 'Unknown Film' }}</span>
                                            </div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-gray-400">Date & Time:</span>
                                                <span class="text-white">
                                                    {{ $ticket->jadwalTayang ? $ticket->jadwalTayang->date->format('M d, Y').' '.$ticket->jadwalTayang->jam_mulai : 'N/A' }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-gray-400">Seat:</span>
                                                <span class="text-white">
                                                    {{ $ticket->kursi ? $ticket->kursi->chair_number : 'N/A' }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-400">Studio:</span>
                                                <span class="text-white">
                                                    {{ $ticket->kursi && $ticket->kursi->studio ? $ticket->kursi->studio->name : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-400 text-center py-2">No tickets found for this transaction</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-800 px-4 py-3 sm:px-6 flex justify-end">
                    <button
                        wire:click="closeModal"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>