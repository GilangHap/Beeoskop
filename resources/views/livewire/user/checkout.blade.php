<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Complete Your Purchase</h1>
            <p class="text-gray-400">
                Please review your booking details and complete the payment
            </p>
        </div>
        
        @if($transactionComplete)
            <!-- Success Section -->
            <div class="max-w-3xl mx-auto bg-dark rounded-xl border border-green-600 border-opacity-30 p-8 text-center">
                <div class="w-20 h-20 bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-white mb-2">Booking Successful!</h2>
                <p class="text-gray-400 mb-6">Your payment is being verified. We'll send a confirmation to your email.</p>
                
                <div class="bg-gray-800 p-4 rounded-lg mb-6">
                    <h3 class="text-gray-300 font-medium mb-2">Booking Code</h3>
                    <p class="text-2xl font-mono font-bold text-primary tracking-wider mb-2">{{ $bookingCode }}</p>
                    <p class="text-sm text-gray-400">Keep this code for reference</p>
                </div>
                
                <div class="flex flex-wrap justify-center gap-4">
                    <a wire:navigate href="{{ route('user.transactions') }}" class="px-6 py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition">
                        View My Bookings
                    </a>
                    <a wire:navigate href="{{ route('movies') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-bold rounded-lg transition">
                        Browse More Movies
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Booking Details -->
                <div class="lg:col-span-2">
                    <!-- Movie & Showtime Details -->
                    <div class="bg-dark rounded-xl p-6 border border-gray-800 mb-6">
                        <div class="flex flex-wrap gap-4">
                            <img 
                                src="{{ $film->poster_url }}" 
                                alt="{{ $film->title }}" 
                                class="w-20 h-30 rounded object-cover"
                                onerror="this.src='https://placehold.co/128x192/1A1A1A/FFCC00.png?text=BEEOSKOP'"
                            >
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-white mb-1">{{ $film->title }}</h2>
                                <div class="mb-2">
                                    <span class="text-gray-400">{{ $film->duration }} minutes | {{ $film->genre->name }}</span>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mt-4">
                                    <div>
                                        <p class="text-gray-400 mb-1">Date & Time</p>
                                        <p class="text-white">
                                            {{ Carbon\Carbon::parse($jadwal->date)->format('l, d M Y') }}<br>
                                            {{ Carbon\Carbon::parse($jadwal->time_start)->format('H:i') }} - {{ Carbon\Carbon::parse($jadwal->time_end)->format('H:i') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-400 mb-1">Studio</p>
                                        <p class="text-white">{{ $studio->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Seat & Ticket Details -->
                    <div class="bg-dark rounded-xl p-6 border border-gray-800 mb-6">
                        <h3 class="text-lg font-medium text-white mb-4">Ticket Details</h3>
                        
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-gray-400">Selected Seats</span>
                                <span class="text-white font-medium">{{ implode(', ', $selectedSeats) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400">Price per Ticket</span>
                                <span class="text-white font-medium">Rp {{ number_format($ticketPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-800">
                            <div class="flex justify-between items-center">
                                <span class="text-lg text-white font-bold">Total</span>
                                <span class="text-xl text-primary font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="bg-dark rounded-xl p-6 border border-gray-800">
                        <h3 class="text-lg font-medium text-white mb-4">Payment Method</h3>
                        
                        <div class="mb-6">
                            <div class="flex items-center mb-3">
                                <input 
                                    type="radio" 
                                    id="bank_transfer" 
                                    value="bank_transfer" 
                                    wire:model.live="paymentMethod"
                                    class="h-4 w-4 text-primary border-gray-700 focus:ring-primary bg-gray-700" 
                                    checked
                                >
                                <label for="bank_transfer" class="ml-2 block text-white">
                                    Bank Transfer
                                </label>
                            </div>
                            
                            <div class="text-xs text-gray-400 ml-6">
                                Transfer the exact amount to our bank account and upload the proof of payment.
                            </div>
                        </div>
                        
                        <!-- Bank Transfer Details -->
                        @if($showPaymentDetails)
                            <div class="p-4 bg-gray-800 rounded-lg mb-6">
                                <h4 class="text-sm font-medium text-white mb-3">Select Bank Account</h4>
                                
                                <div class="flex flex-wrap gap-3">
                                    @foreach($bankAccounts as $code => $bank)
                                        <button 
                                            type="button" 
                                            wire:click="$set('selectedBank', '{{ $code }}')"
                                            class="px-4 py-2 border rounded-lg {{ $selectedBank === $code ? 'border-primary bg-primary/10 text-white' : 'border-gray-700 bg-gray-900 text-gray-400 hover:bg-gray-800' }}"
                                        >
                                            {{ $bank['name'] }}
                                        </button>
                                    @endforeach
                                </div>
                                
                                <div class="mt-4 bg-gray-900/50 p-4 rounded-lg">
                                    <div class="mb-2">
                                        <label class="block text-sm text-gray-400">Account Number</label>
                                        <div class="flex items-center mt-1">
                                            <span class="text-white font-mono text-lg">{{ $bankAccounts[$selectedBank]['account_number'] }}</span>
                                            <button 
                                                type="button" 
                                                onclick="copyToClipboard('{{ $bankAccounts[$selectedBank]['account_number'] }}')"
                                                class="ml-2 text-primary hover:text-yellow-400 text-sm"
                                            >
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm text-gray-400">Account Name</label>
                                        <span class="text-white">{{ $bankAccounts[$selectedBank]['account_name'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Upload Payment Proof -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-white mb-2">Upload Payment Proof</label>
                            <div class="border-2 border-dashed border-gray-700 rounded-lg p-4 {{ $paymentProof ? 'border-primary' : '' }}">
                                @if($paymentProof)
                                    <div class="relative">
                                        <img 
                                            src="{{ $paymentProof->temporaryUrl() }}" 
                                            alt="Payment proof" 
                                            class="w-full h-48 object-cover rounded"
                                        >
                                        <button 
                                            type="button" 
                                            wire:click="$set('paymentProof', null)"
                                            class="absolute top-2 right-2 bg-red-500 rounded-full p-1 text-white hover:bg-red-600"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <div 
                                        x-data="{ isHovering: false }"
                                        @dragover.prevent="isHovering = true"
                                        @dragleave="isHovering = false"
                                        @drop.prevent="isHovering = false; if ($event.dataTransfer.files.length > 0) { document.getElementById('payment-proof').files = $event.dataTransfer.files; const event = new Event('change', { bubbles: true }); document.getElementById('payment-proof').dispatchEvent(event); }"
                                        :class="{ 'bg-primary/10': isHovering }"
                                        class="text-center py-8 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <label for="payment-proof" class="block mb-2 text-gray-300 font-medium cursor-pointer">
                                            Click to upload or drag and drop
                                        </label>
                                        <p class="text-xs text-gray-500">JPG, PNG or JPEG (max. 2MB)</p>
                                        <input 
                                            type="file" 
                                            id="payment-proof" 
                                            wire:model.live="paymentProof" 
                                            accept="image/png,image/jpeg,image/jpg" 
                                            class="hidden"
                                        >
                                    </div>
                                @endif
                            </div>
                            @error('paymentProof') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Summary & Actions -->
                <div>
                    <div class="bg-dark rounded-xl border border-gray-800 sticky top-24">
                        <!-- Countdown timer -->
                        <div class="p-4 bg-amber-900/20 border-b border-amber-700/30 rounded-t-xl">
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-400 font-medium">Booking Session</span>
                                
                                @if($countdownExpired)
                                    <span class="text-red-400 font-mono">EXPIRED</span>
                                @else
                                    <span class="text-white font-mono">
                                        {{ sprintf('%02d:%02d', $countdownMinutes, $countdownSeconds) }}
                                    </span>
                                @endif
                            </div>
                            
                            <div class="mt-1 text-xs text-gray-400">
                                @if($countdownExpired)
                                    Your booking session has expired. Please restart your selection.
                                @else
                                    Complete your payment before the timer expires.
                                @endif
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white mb-4">Order Summary</h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">{{ count($selectedSeats) }} ticket(s)</span>
                                    <span class="text-white">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Service Fee</span>
                                    <span class="text-white">Free</span>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-800">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-white">Total Payment</span>
                                        <span class="font-bold text-primary">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Complete Payment Button -->
                            <form wire:submit.prevent="completeTransaction">
                                <button 
                                    type="submit"
                                    class="w-full py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition flex items-center justify-center {{ $countdownExpired || !$paymentProof ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $countdownExpired || !$paymentProof ? 'disabled' : '' }}
                                >
                                    <span wire:loading.remove wire:target="completeTransaction">
                                        Complete Payment
                                    </span>
                                    <span wire:loading wire:target="completeTransaction">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </form>

                            <!-- Notifikasi -->
                            <div class="mt-3 text-center text-xs text-gray-400">
                                <span wire:loading wire:target="paymentProof">
                                    Uploading image...
                                </span>
                                @if(!$paymentProof)
                                    <span class="text-amber-400">Please upload payment proof before completing your transaction</span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="p-4 border-t border-gray-800 text-xs text-gray-400">
                            <p>By completing this payment, you agree to our <a href="#" class="text-primary">Terms & Conditions</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- JavaScript for copy to clipboard -->
    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    // Show a brief notification
                    showNotification('Copied to clipboard!');
                })
                .catch(err => console.error('Failed to copy: ', err));
        }

        // Notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.textContent = message;
            
            // Set style based on type
            let bgColor = '#3B82F6'; // Default blue
            if (type === 'success') bgColor = '#10B981';
            if (type === 'error') bgColor = '#EF4444';
            if (type === 'warning') bgColor = '#F59E0B';
            
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                padding: 10px 20px;
                background: ${bgColor};
                color: #FFFFFF;
                border-radius: 4px;
                z-index: 9999;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => document.body.removeChild(notification), 500);
            }, 3000);
        }

        // Add event listener for alerts
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('alert', event => {
                showNotification(event.detail.message, event.detail.type);
            });
        });
    </script>
</div>

