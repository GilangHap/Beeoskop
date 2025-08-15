<div>
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white">Film Management</h1>
                <p class="mt-1 text-sm text-gray-400">Manage your movie collection</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('admin.film.create') }}" wire:navigate class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Film
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-dark/60 border border-gray-800 rounded-xl p-4 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="search" 
                    wire:model.live.debounce.300ms="search" 
                    class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                    placeholder="Search films by title, producer, or synopsis..."
                />
            </div>

            <div class="flex flex-wrap md:flex-nowrap gap-3">
                <!-- Genre Filter -->
                <div class="w-full md:w-48">
                    <select 
                        wire:model.live="filterGenre"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-sm text-white focus:outline-none focus:border-primary"
                    >
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Filter -->
                <div class="w-full md:w-36">
                    <select 
                        wire:model.live="filterYear"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-sm text-white focus:outline-none focus:border-primary"
                    >
                        <option value="">All Years</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Release Status Filter -->
                <div class="w-full md:w-48">
                    <select 
                        wire:model.live="filterReleaseStatus"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-sm text-white focus:outline-none focus:border-primary"
                    >
                        <option value="">All Release Status</option>
                        <option value="released">Released</option>
                        <option value="unreleased">Not Released Yet</option>
                    </select>
                </div>

                <!-- Showing Status Filter -->
                <div class="w-full md:w-48">
                    <select 
                        wire:model.live="filterShowing"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-sm text-white focus:outline-none focus:border-primary"
                    >
                        <option value="">All Status</option>
                        <option value="1">Now Showing</option>
                        <option value="0">Not Showing</option>
                    </select>
                </div>

                <!-- Per Page -->
                <div class="w-full md:w-36">
                    <select 
                        wire:model.live="perPage"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-sm text-white focus:outline-none focus:border-primary"
                    >
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Film Table -->
    <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-800/50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Poster</th>
                        <th wire:click="sortBy('title')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
                                @if ($sortField === 'title')
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('producer')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center space-x-1">
                                <span>Producer</span>
                                @if ($sortField === 'producer')
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('year')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center space-x-1">
                                <span>Year</span>
                                @if ($sortField === 'year')
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('duration')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center space-x-1">
                                <span>Duration</span>
                                @if ($sortField === 'duration')
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('release_date')" class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider cursor-pointer">
                            <div class="flex items-center space-x-1">
                                <span>Release Date</span>
                                @if ($sortField === 'release_date')
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Genre</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($films as $film)
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-16 w-12 flex-shrink-0 overflow-hidden rounded-md bg-gray-700">
                                    @if ($film->poster_url)
                                        <img src="{{ $film->poster_url }}" alt="{{ $film->title }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[180px] lg:max-w-xs">
                                <div class="font-medium text-white">{{ $film->title }}</div>
                                <div class="text-xs text-gray-400 mt-1 truncate">{{ Str::limit($film->sinopsis, 50) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $film->producer ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $film->year ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            @if ($film->duration)
                                <span class="bg-gray-700 text-gray-300 px-2 py-1 rounded-md text-xs">
                                    {{ $film->duration }} min
                                </span>
                            @else
                                <span>N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            @if ($film->release_date)
                                @if ($film->release_date->isPast())
                                    <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-md text-xs">
                                        Released {{ $film->release_date->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="bg-yellow-500/20 text-yellow-400 px-2 py-1 rounded-md text-xs">
                                        Releases {{ $film->release_date->format('M d, Y') }}
                                    </span>
                                @endif
                            @else
                                <span class="bg-gray-700 text-gray-400 px-2 py-1 rounded-md text-xs">No date</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">
                                {{ $film->genre->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($film->release_date && $film->release_date->isPast())
                                <button 
                                    wire:click="toggleShowingStatus({{ $film->id }})" 
                                    class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50"
                                    :class="{{ $film->is_showing ? 'true' : 'false' }} ? 'bg-primary' : 'bg-gray-700'"
                                >
                                    <span 
                                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                                        :class="{{ $film->is_showing ? 'true' : 'false' }} ? 'translate-x-5' : 'translate-x-0'"
                                    ></span>
                                    <span class="sr-only">{{ $film->is_showing ? 'Showing' : 'Not Showing' }}</span>
                                </button>
                                <span class="{{ $film->is_showing ? 'text-green-400' : 'text-gray-400' }} ml-2">{{ $film->is_showing ? 'Showing' : 'Not Showing' }}</span>
                            @else
                                <span class="bg-gray-700 text-gray-400 px-2 py-1 rounded-md text-xs">Not Released</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.film.edit', $film->id) }}" wire:navigate class="text-blue-400 hover:text-blue-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <button wire:click="confirmDelete({{ $film->id }})" class="text-red-400 hover:text-red-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button wire:click="showDetail({{ $film->id }})" class="text-gray-400 hover:text-gray-300 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                </svg>
                                <span class="text-gray-500 text-lg font-medium">No films found</span>
                                <p class="text-gray-400 text-sm mt-1">Try changing your search criteria or add a new film</p>
                                <a href="{{ route('admin.film.create') }}" wire:navigate class="mt-4 px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors">
                                    Add New Film
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($films->hasPages())
            <div class="px-6 py-3 border-t border-gray-800">
                {{ $films->links('livewire.custom-pagination') }}
            </div>
        @endif
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
                            Delete Film
                        </h3>
                        <p class="text-gray-400">
                            Are you sure you want to delete this film? This action cannot be undone.
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
                            wire:click="deleteFilm" 
                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="deleteFilm">Delete</span>
                            <span wire:loading wire:target="deleteFilm">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<!-- Film Detail Modal -->
    <div x-data="{ show: @entangle('showDetailModal') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                @click="$wire.closeDetail()"
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
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-3xl transform transition-all sm:my-8 overflow-hidden"
            >
                @if($detailFilm)
                    <div class="flex flex-col md:flex-row">
                        <!-- Poster Section -->
                        <div class="md:w-1/3">
                            <div class="relative w-full aspect-[2/3] bg-gray-800">
                                @if($detailFilm->poster_url)
                                    <img src="{{ $detailFilm->poster_url }}" alt="{{ $detailFilm->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="md:w-2/3 p-6 flex flex-col">
                            <div class="flex justify-between items-start">
                                <h2 class="text-2xl font-bold text-white">{{ $detailFilm->title }}</h2>
                                <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">
                                    {{ $detailFilm->genre->name }}
                                </span>
                                @if($detailFilm->year)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                                        {{ $detailFilm->year }}
                                    </span>
                                @endif
                                @if($detailFilm->duration)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-700 text-gray-300">
                                        {{ $detailFilm->duration }} min
                                    </span>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-400">Producer</h3>
                                <p class="text-white">{{ $detailFilm->producer ?? 'Not specified' }}</p>
                            </div>

                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-400">Release Date</h3>
                                <p class="text-white">
                                    @if($detailFilm->release_date)
                                        {{ $detailFilm->release_date->format('F d, Y') }}
                                        @if($detailFilm->release_date->isPast())
                                            <span class="inline-block ml-2 px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">Released</span>
                                        @else
                                            <span class="inline-block ml-2 px-2 py-0.5 bg-yellow-500/20 text-yellow-400 text-xs rounded-full">Coming Soon</span>
                                        @endif
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-400">Status</h3>
                                <p class="text-white">
                                    @if($detailFilm->is_showing)
                                        <span class="inline-block px-2 py-0.5 bg-green-500/20 text-green-400 rounded-full">Now Showing</span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 bg-gray-700/60 text-gray-400 rounded-full">Not Showing</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mt-4">
                                <h3 class="text-sm font-medium text-gray-400">Synopsis</h3>
                                <div class="mt-1 text-white text-sm prose prose-invert max-w-none">
                                    <p>{{ $detailFilm->sinopsis ?? 'No synopsis available.' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex space-x-3 justify-end mt-auto">
                                <a href="{{ route('admin.film.edit', $detailFilm->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit Film
                                </a>
                                <button wire:click="closeDetail" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-600 rounded-md font-semibold text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-700 focus:outline-none transition">
                                    Close
                                </button>
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
