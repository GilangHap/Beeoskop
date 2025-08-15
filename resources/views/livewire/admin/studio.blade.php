<div>
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white">Studio Management</h1>
                <p class="mt-1 text-sm text-gray-400">Manage your cinema studios and seating arrangements</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button 
                    wire:click="openModal('create')" 
                    class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Studio
                </button>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="mb-6 relative">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="search" 
                wire:model.live.debounce.300ms="search" 
                class="pl-10 pr-4 py-2 w-full md:w-64 bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                placeholder="Search studios..."
            />
        </div>
    </div>
    
    <!-- Studios Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse ($studios as $studio)
            <div class="bg-dark border border-gray-800 rounded-xl overflow-hidden shadow-md hover:border-gray-700 transition-colors group">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-white group-hover:text-primary transition-colors">{{ $studio->name }}</h2>
                        <div class="flex space-x-1">
                            <!-- Edit Button -->
                            <button 
                                wire:click="openModal('edit', {{ $studio->id }})" 
                                class="text-gray-400 hover:text-blue-400 transition-colors p-1"
                                title="Edit Studio"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                            
                            <!-- Delete Button -->
                            <button 
                                wire:click="confirmDelete({{ $studio->id }})" 
                                class="text-gray-400 hover:text-red-400 transition-colors p-1"
                                title="Delete Studio"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <!-- Seat Management Button -->
                            <a 
                                href="{{ route('admin.studio.seats', $studio->id) }}" wire:navigate
                                class="text-gray-400 hover:text-primary transition-colors p-1"
                                title="Manage Seats"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Studio Info -->
                    <div class="mt-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-400">Capacity:</span>
                            <span class="text-sm text-white font-medium">{{ $studio->capacity }} seats</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-400">Seats Configured:</span>
                            <span class="text-sm font-medium {{ $studio->seat_count == $studio->capacity ? 'text-green-400' : 'text-yellow-400' }}">
                                {{ $studio->seat_count }} / {{ $studio->capacity }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-400">Active Schedules:</span>
                            <span class="text-sm text-white font-medium">{{ $studio->schedule_count }}</span>
                        </div>
                    </div>
                    
                    <!-- Studio Visualization -->
                    <div class="mt-6 relative">
                        <div class="bg-gray-800/80 rounded-lg p-4 flex flex-col items-center">
                            <!-- Screen -->
                            <div class="w-3/4 h-4 bg-gray-600 rounded-t-lg mb-5 relative">
                                <div class="absolute -top-5 left-0 right-0 text-center text-xs text-gray-400">SCREEN</div>
                            </div>
                            
                            <!-- Seating Visualization -->
                            <div class="w-full flex flex-wrap justify-center gap-1 max-h-28 overflow-hidden">
                                @php
                                    // This is just for visualization, limited to show max 48 seats
                                    $seatCount = min($studio->capacity, 48);
                                    $rows = ceil($seatCount / 8);
                                    $seatsPerRow = ceil($seatCount / $rows);
                                @endphp
                                
                                @for ($i = 0; $i < $seatCount; $i++)
                                    <div class="w-2 h-2 bg-primary rounded-sm opacity-70"></div>
                                @endfor
                            </div>
                            
                            @if($studio->capacity > 48)
                                <div class="text-xs text-gray-400 mt-2">+ {{ $studio->capacity - 48 }} more seats</div>
                            @endif
                        </div>
                        
                        <!-- Configuration Status -->
                        <div class="absolute -top-2 -right-2">
                            @if($studio->seat_count == $studio->capacity)
                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full border border-green-500/20">
                                    Fully Configured
                                </span>
                            @else
                                <span class="bg-yellow-500/20 text-yellow-400 text-xs px-2 py-1 rounded-full border border-yellow-500/20">
                                    Partially Configured
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="bg-gray-800/50 p-4 border-t border-gray-800">
                    @if($studio->seat_count < $studio->capacity)
                        <a href="{{ route('admin.studio.seats', $studio->id) }}" wire:navigate class="w-full py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Configure Seats
                        </a>
                    @else
                        <a href="{{ route('admin.studio.seats', $studio->id) }}" wire:navigate class="w-full py-2 bg-gray-700 text-gray-300 font-medium rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            View Seating
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-dark border border-gray-800 rounded-xl p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">No Studios Found</h3>
                <p class="text-gray-400 mb-6">Create your first studio to get started</p>
                <button 
                    wire:click="openModal('create')" 
                    class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors inline-flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Studio
                </button>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if ($studios->hasPages())
        <div class="pt-3 pb-6">
            {{ $studios->links('livewire.custom-pagination') }}
        </div>
    @endif
    
    <!-- Studio Form Modal -->
    <div x-data="{ show: @entangle('isModalOpen') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            
            <!-- Overlay -->
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
                @click="$wire.closeModal()"
            ></div>

            <!-- Modal Panel -->
            <div 
                x-show="show" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-md transform transition-all sm:my-8"
            >
                <div class="px-6 pt-5 pb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-white">
                            {{ $isEditMode ? 'Edit Studio' : 'Add New Studio' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <!-- Studio Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-1">
                                    Studio Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    wire:model.blur="name" 
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                    placeholder="Enter studio name"
                                    autofocus
                                >
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-300 mb-1">
                                    Seating Capacity <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        id="capacity" 
                                        wire:model.blur="capacity" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 pl-4 pr-12 text-white focus:outline-none focus:border-primary"
                                        placeholder="Enter seating capacity"
                                        min="1"
                                    >
                                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                        seats
                                    </div>
                                </div>
                                @error('capacity') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Note about seat configuration -->
                            <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-800">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs text-gray-400">
                                        After creating the studio, you'll need to configure the seating arrangement. 
                                        This will determine how tickets are sold for this studio.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button 
                                type="button"
                                wire:click="closeModal" 
                                class="px-4 py-2 bg-gray-800 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors focus:outline-none"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="save">
                                    {{ $isEditMode ? 'Update Studio' : 'Create Studio' }}
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: @entangle('confirmingDeletion') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            
            <!-- Overlay -->
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
                @click="$wire.cancelDelete()"
            ></div>

            <!-- Modal Panel -->
            <div 
                x-show="show" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-md transform transition-all sm:my-8"
            >
                <div class="px-6 pt-5 pb-5">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center text-red-500 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">
                            Delete Studio
                        </h3>
                        <p class="text-gray-400">
                            Are you sure you want to delete this studio? This will also remove all seats configured for this studio. This action cannot be undone.
                        </p>
                    </div>

                    <div class="flex justify-center space-x-3">
                        <button
                            type="button"
                            wire:click="cancelDelete" 
                            class="px-4 py-2 bg-gray-800 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            wire:click="deleteStudio" 
                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="deleteStudio">Delete</span>
                            <span wire:loading wire:target="deleteStudio" class="flex items-center">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Deleting...
                            </span>
                        </button>
                    </div>
                </div>
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
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
