<div class="container mx-auto px-4 py-8">
    <!-- Profile Header -->
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-6 mb-8 border border-gray-700/50">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- User Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $name }}</h1>
                <p class="text-primary flex items-center justify-center md:justify-start mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ $username }}
                </p>
                <p class="text-gray-300 flex items-center justify-center md:justify-start mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $email }}
                </p>
                @if($phone)
                    <p class="text-gray-300 flex items-center justify-center md:justify-start mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $phone }}
                    </p>
                @endif
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-4 md:mt-0">
                @if(!$isEditingProfile)
                    <button 
                        wire:click="startEditingProfile"
                        class="px-4 py-2 bg-primary hover:bg-yellow-400 text-black rounded-lg font-medium transition flex items-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </button>
                @else
                    <div class="flex space-x-2">
                        <button 
                            wire:click="updateProfile"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save
                        </button>
                        
                        <button 
                            wire:click="cancelEditingProfile"
                            class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Profile Information -->
        <div class="md:col-span-2">
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile Information
                </h2>
                
                <!-- Success Message -->
                @if($successMessage)
                    <div class="mb-4 p-4 bg-green-900/30 border border-green-600/20 rounded-lg">
                        <p class="text-green-400 text-sm">{{ $successMessage }}</p>
                    </div>
                @endif
                
                <!-- Profile Form -->
                <form wire:submit="updateProfile" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-1">Full Name</label>
                        <input type="text" id="name" wire:model="name" @readonly(!$isEditingProfile)
                            class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border {{ $isEditingProfile ? 'border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary' : 'border-transparent' }} text-white placeholder-gray-400"
                        >
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-400 mb-1">Username</label>
                        <input type="text" id="username" wire:model="username" @readonly(!$isEditingProfile)
                            class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border {{ $isEditingProfile ? 'border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary' : 'border-transparent' }} text-white placeholder-gray-400"
                        >
                        @error('username') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <input type="email" id="email" wire:model="email" @readonly(!$isEditingProfile)
                            class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border {{ $isEditingProfile ? 'border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary' : 'border-transparent' }} text-white placeholder-gray-400"
                        >
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-400 mb-1">Phone Number</label>
                        <input type="tel" id="phone" wire:model="phone" @readonly(!$isEditingProfile)
                            class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border {{ $isEditingProfile ? 'border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary' : 'border-transparent' }} text-white placeholder-gray-400"
                            placeholder="{{ $isEditingProfile ? 'Enter your phone number' : 'Not provided' }}"
                        >
                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </form>
            </div>

            <!-- Change Password Section -->
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 mt-8">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Password
                </h2>

                <button 
                    wire:click="toggleChangePassword"
                    class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-medium transition flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ $isChangingPassword ? 'Cancel' : 'Change Password' }}
                </button>

                @if($isChangingPassword)
                    <form wire:submit="changePassword" class="mt-4 space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-400 mb-1">Current Password</label>
                            <input type="password" id="current_password" wire:model="current_password"
                                class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary text-white"
                            >
                            @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-400 mb-1">New Password</label>
                            <input type="password" id="new_password" wire:model="new_password"
                                class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary text-white"
                            >
                            @error('new_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-400 mb-1">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" wire:model="new_password_confirmation"
                                class="w-full px-4 py-2.5 rounded-lg bg-gray-800 border border-gray-600 focus:border-primary focus:ring-1 focus:ring-primary text-white"
                            >
                        </div>

                        <div>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-primary hover:bg-yellow-400 text-black rounded-lg font-medium transition"
                            >
                                Update Password
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Account Overview -->
        <div>
            <!-- Account Stats Card -->
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 mb-8">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Account Overview
                </h2>
                
                <div class="space-y-4">
                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-800/50 rounded-lg p-4 text-center border border-gray-700/30">
                            <p class="text-gray-400 text-sm">Total Bookings</p>
                            <p class="text-3xl font-bold text-primary mt-1">{{ auth()->user()->transaksis()->count() }}</p>
                        </div>
                        
                        <div class="bg-gray-800/50 rounded-lg p-4 text-center border border-gray-700/30">
                            <p class="text-gray-400 text-sm">Total Spent</p>
                            <p class="text-3xl font-bold text-primary mt-1">Rp {{ number_format(auth()->user()->transaksis()->sum('total_payment'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <!-- Recent Activity Label -->
                    <div class="pt-4 mt-4 border-t border-gray-800">
                        <p class="text-sm text-gray-400 mb-2">Recent Activity</p>
                        
                        <div class="space-y-2">
                            @forelse(auth()->user()->transaksis()->latest()->take(3)->get() as $transaction)
                                <div class="flex items-center p-3 bg-gray-800/30 rounded-lg">
                                    <div class="mr-3 w-8 h-8 flex-shrink-0 rounded-full bg-primary/20 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white truncate">{{ $transaction->booking_code }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex px-2 py-0.5 rounded text-xs 
                                            @if($transaction->payment_status == 'Success') bg-green-900/30 text-green-400
                                            @elseif($transaction->payment_status == 'Pending') bg-yellow-900/30 text-yellow-400
                                            @elseif($transaction->payment_status == 'Cancelled') bg-red-900/30 text-red-400
                                            @elseif($transaction->payment_status == 'Failed') bg-blue-900/30 text-blue-400
                                            @else bg-gray-900/30 text-gray-400 @endif">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 bg-gray-800/30 rounded-lg text-center text-gray-400 text-sm">
                                    No transactions found
                                </div>
                            @endforelse
                        </div>
                        
                        <a href="{{ route('user.transactions') }}" wire:navigate class="block mt-4 text-sm text-center text-primary hover:text-yellow-400 transition">
                            View all bookings
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Help & Support -->
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Help & Support
                </h2>
                
                <div class="space-y-4">
                    <a href="#" class="block p-4 bg-gray-800/50 rounded-lg hover:bg-gray-800 transition">
                        <div class="flex items-center">
                            <div class="mr-3 w-8 h-8 flex-shrink-0 rounded-full bg-primary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Contact Support</p>
                                <p class="text-xs text-gray-400">Get help with your account</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="#" class="block p-4 bg-gray-800/50 rounded-lg hover:bg-gray-800 transition">
                        <div class="flex items-center">
                            <div class="mr-3 w-8 h-8 flex-shrink-0 rounded-full bg-primary/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">FAQ</p>
                                <p class="text-xs text-gray-400">Find answers to common questions</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('notify', params => {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${params.type === 'success' ? 'bg-green-800 text-green-100' : 'bg-red-800 text-red-100'}`;
                notification.textContent = params.message;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 3000);
            });
        });
    </script>
</div>
