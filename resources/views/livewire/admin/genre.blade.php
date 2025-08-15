<div>
    <!-- Page Header -->
    {{-- <x-slot name="header"> --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">Genre Management</h1>
            <button 
                wire:click="create" 
                class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors flex items-center"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add New Genre
            </button>
        </div>
    {{-- </x-slot> --}}

    <!-- Search Bar -->
    <div class="mb-6 bg-dark/60 border border-gray-800 rounded-xl p-4">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="search" 
                    wire:model.live.debounce.300ms="search" 
                    class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                    placeholder="Search genres..."
                />
            </div>
            <div class="flex items-center gap-2">
                <span class="text-gray-400 text-sm">
                    {{ $genres->total() }} genres found
                </span>
                <div>
                    <button class="p-2 rounded-lg hover:bg-gray-700 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Genre Table -->
    <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/50 text-left">
                        <th wire:click="sortBy('id')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center">
                                ID
                                @if ($sortField === 'id')
                                    <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('name')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center">
                                Name
                                @if ($sortField === 'name')
                                    <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Movies</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($genres as $genre)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $genre->id }}</td>
                            <td class="px-6 py-4 text-sm text-white font-medium">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                        </svg>
                                    </div>
                                    {{ $genre->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full">
                                    {{ $genre->films->count() }} films
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $genre->created_at ? $genre->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                <div class="flex items-center gap-3">
                                    <button 
                                        wire:click="edit({{ $genre->id }})" 
                                        class="text-blue-400 hover:text-blue-300 transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </button>
                                    <button 
                                        wire:click="confirmDelete({{ $genre->id }})" 
                                        class="text-red-400 hover:text-red-300 transition-colors"
                                        @if($genre->films->count() > 0) title="Cannot delete: has associated films" @endif
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-gray-500 text-lg font-medium">No genres found</span>
                                    <p class="text-gray-400 text-sm mt-1">Try changing your search criteria or add a new genre</p>
                                    <button 
                                        wire:click="create" 
                                        class="mt-4 px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors"
                                    >
                                        Add New Genre
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($genres->hasPages())
            <div class="px-6 py-3 flex justify-between items-center border-t border-gray-800">
                <div class="flex-1 flex justify-between md:hidden">
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="{{ !$genres->onFirstPage() ? 'text-gray-300 hover:text-white' : 'text-gray-600 cursor-not-allowed' }} px-4 py-2 text-sm font-medium bg-gray-800 rounded-md">
                        Previous
                    </button>
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="{{ $genres->hasMorePages() ? 'text-gray-300 hover:text-white' : 'text-gray-600 cursor-not-allowed' }} px-4 py-2 text-sm font-medium bg-gray-800 rounded-md">
                        Next
                    </button>
                </div>
                <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                    <div>
                        <p class="text-sm text-gray-400">
                            Showing
                            <span class="font-medium">{{ $genres->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $genres->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $genres->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        {{ $genres->links('livewire.custom-pagination') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-cloak x-show="$wire.showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            
            <!-- Overlay -->
            <div 
                x-show="$wire.showModal" 
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
                x-show="$wire.showModal" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-lg transform transition-all sm:my-8"
            >
                <div class="px-6 pt-5 pb-5">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-white">
                            {{ $genreId ? 'Edit Genre' : 'Create New Genre' }}
                        </h3>
                        <button @click="$wire.closeModal()" class="text-gray-400 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save">
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Genre Name</label>
                            <input type="text" id="name" wire:model="name" 
                                class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                placeholder="Enter genre name"
                                autofocus
                            >
                            @error('name') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button
                                type="button"
                                @click="$wire.closeModal()" 
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
                                    {{ $genreId ? 'Update Genre' : 'Create Genre' }}
                                </span>
                                <span wire:loading wire:target="save">
                                    <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-cloak x-show="$wire.confirmingDeletion" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            
            <!-- Overlay -->
            <div 
                x-show="$wire.confirmingDeletion" 
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
                x-show="$wire.confirmingDeletion" 
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
                            Delete Genre
                        </h3>
                        <p class="text-gray-400">
                            Are you sure you want to delete this genre? This action cannot be undone.
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
                            wire:click="deleteGenre" 
                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="deleteGenre">Delete</span>
                            <span wire:loading wire:target="deleteGenre">Deleting...</span>
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
