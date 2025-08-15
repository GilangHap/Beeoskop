<div class="py-4">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $pageTitle }}</h1>
                <p class="mt-1 text-sm text-gray-400">{{ $isEditing ? 'Edit film details' : 'Add a new film to your collection' }}</p>
            </div>
            <a href="{{ route('admin.film') }}" wire:navigate class="px-4 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 rounded-lg text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Films
            </a>
        </div>
    </div>
    
    <!-- Form Container -->
    <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Poster Upload -->
                <div class="lg:col-span-1">
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-lg font-medium text-white mb-2">Film Poster</h2>
                            
                            <!-- Poster Preview -->
                            <div class="mb-4 aspect-[2/3] bg-gray-800 border border-gray-700 rounded-lg overflow-hidden relative">
                                @if ($poster)
                                    <img src="{{ $poster->temporaryUrl() }}" alt="Poster Preview" class="w-full h-full object-cover">
                                @elseif ($poster_url)
                                    <img src="{{ $poster_url }}" alt="Current Poster" class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-400 p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-center">No poster uploaded</p>
                                    </div>
                                @endif
                                
                                <!-- File Input -->
                                <div class="absolute inset-0 opacity-0 hover:opacity-100 bg-black/50 flex items-center justify-center transition-opacity">
                                    <label for="poster-upload" class="cursor-pointer text-white hover:text-primary transition-colors bg-gray-800/80 px-4 py-2 rounded-lg border border-gray-600">
                                        <span>{{ $poster_url ? 'Change Poster' : 'Upload Poster' }}</span>
                                    </label>
                                </div>
                                <input 
                                    id="poster-upload" 
                                    type="file" 
                                    wire:model="poster" 
                                    accept="image/*" 
                                    class="hidden"
                                >
                            </div>
                            
                            @error('poster')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            
                            <p class="text-xs text-gray-400 mt-2">Recommended size: 300x450px. Max 2MB.</p>
                        </div>
                        
                        <!-- Release Date -->
                        <div>
                            <h2 class="text-md font-medium text-white mb-2">Release Date</h2>
                            <div class="relative">
                                <input 
                                    type="date" 
                                    wire:model="release_date" 
                                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('release_date')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 mt-2">
                                @if($release_date)
                                    @if(\Carbon\Carbon::parse($release_date)->isPast())
                                        <span class="text-green-500">This film is already released and can be shown</span>
                                    @else
                                        <span class="text-yellow-500">This film will be automatically set to showing after {{ \Carbon\Carbon::parse($release_date)->format('M d, Y') }}</span>
                                    @endif
                                @else
                                    <span>Set a release date to make the film available for showing</span>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Status Toggle -->
                        <div>
                            <h2 class="text-md font-medium text-white mb-2">Film Status</h2>
                            <div class="flex items-center">
                                <label for="is_showing" class="relative inline-flex items-center cursor-pointer {{ $canToggleShowing ? '' : 'opacity-50' }}">
                                    <input 
                                        type="checkbox" 
                                        id="is_showing" 
                                        wire:model="is_showing" 
                                        class="sr-only peer" 
                                        {{ $canToggleShowing ? '' : 'disabled' }}
                                    >
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-300">{{ $is_showing ? 'Now Showing' : 'Not Showing' }}</span>
                                </label>
                                
                                @if(!$canToggleShowing)
                                    <div class="ml-3">
                                        <div class="relative group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div class="absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 invisible group-hover:visible bg-gray-800 text-xs text-white p-2 rounded whitespace-nowrap">
                                                Film must be released before you can manually toggle its showing status
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <p class="text-xs text-gray-400 mt-2">
                                @if($canToggleShowing)
                                    You can manually toggle the showing status since the release date has passed.
                                @else
                                    Status will be automatically set based on release date.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Film Details -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-300">Film Title <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            id="title" 
                            wire:model="title" 
                            class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                            placeholder="Enter film title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Producer -->
                    <div>
                        <label for="producer" class="block text-sm font-medium text-gray-300">Producer</label>
                        <input 
                            type="text" 
                            id="producer" 
                            wire:model="producer" 
                            class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                            placeholder="Enter producer name"
                        >
                        @error('producer')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Year -->
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-300">Year <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                id="year" 
                                wire:model="year" 
                                class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                                placeholder="2023"
                                min="1900"
                                max="2099"
                            >
                            @error('year')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Duration -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-300">Duration (min) <span class="text-red-500">*</span></label>
                            <input 
                                type="number" 
                                id="duration" 
                                wire:model="duration" 
                                class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                                placeholder="120"
                                min="1"
                            >
                            @error('duration')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Genre -->
                        <div>
                            <label for="genre_id" class="block text-sm font-medium text-gray-300">Genre <span class="text-red-500">*</span></label>
                            <select 
                                id="genre_id" 
                                wire:model="genre_id" 
                                class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                            >
                                <option value="">Select Genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                            @error('genre_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Synopsis -->
                    <div>
                        <label for="sinopsis" class="block text-sm font-medium text-gray-300">Synopsis</label>
                        <textarea 
                            id="sinopsis" 
                            wire:model="sinopsis" 
                            rows="6" 
                            class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm py-2 px-3 text-white focus:outline-none focus:ring-2 focus:ring-primary/50"
                            placeholder="Enter film synopsis"
                        ></textarea>
                        @error('sinopsis')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 border-t border-gray-800 pt-5 flex justify-end space-x-3">
                <a href="{{ route('admin.film') }}" wire:navigate class="px-4 py-2 bg-gray-800 border border-gray-700 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors focus:outline-none"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-75"
                >
                    <span wire:loading.remove>{{ $isEditing ? 'Update Film' : 'Add Film' }}</span>
                    <span wire:loading>
                        <svg class="animate-spin h-5 w-5 text-black inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $isEditing ? 'Updating...' : 'Adding...' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Toast Notification -->
    <div
        x-data="{ show: @entangle('showAlert').defer }"
        x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false"
        class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50"
    >
        <div class="max-w-sm w-full bg-dark border" :class="{'border-green-500': '{{ $alertType }}' === 'success', 'border-red-500': '{{ $alertType }}' === 'error'}" class="rounded-lg shadow-lg pointer-events-auto">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <!-- Success Icon -->
                        <div x-show="'{{ $alertType }}' === 'success'" class="h-6 w-6 text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <!-- Error Icon -->
                        <div x-show="'{{ $alertType }}' === 'error'" class="h-6 w-6 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium" :class="{'text-green-500': '{{ $alertType }}' === 'success', 'text-red-500': '{{ $alertType }}' === 'error'}">
                            {{ $alertType === 'success' ? 'Success!' : 'Error!' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-300">
                            {{ $alertMessage }}
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button class="inline-flex text-gray-400 hover:text-gray-300">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
