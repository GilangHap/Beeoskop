<div>
    <!-- Movies Browse Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-2">Movie Collection</h1>
        <p class="text-gray-400">Browse our extensive collection of movies</p>
    </div>

    <!-- Filter Bar yang Diperbaiki -->
    <div class="bg-dark rounded-xl p-6 mb-8 sticky top-20 z-10 border border-gray-800 shadow-lg">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Search (lebih lebar) -->
            <div class="relative lg:col-span-5">
                <label class="block text-sm font-medium text-gray-400 mb-2">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="text" 
                        placeholder="Search by title, producer, or synopsis..." 
                        class="block w-full pl-10 pr-3 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    >
                </div>
            </div>
            
            <!-- Genre Filter (lebih kecil) -->
            <div class="lg:col-span-4">
                <label class="block text-sm font-medium text-gray-400 mb-2">Genre</label>
                <div class="relative">
                    <select 
                        wire:model.live="selectedGenre" 
                        class="block w-full py-3 px-4 pr-10 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none"
                    >
                        <option value="all">All Genres</option>
                        @foreach($genreList as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Sort By (lebih kecil) -->
            <div class="lg:col-span-3">
                <label class="block text-sm font-medium text-gray-400 mb-2">Sort By</label>
                <div class="relative">
                    <select 
                        wire:model.live="sortBy" 
                        class="block w-full py-3 px-4 pr-10 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent appearance-none"
                    >
                        <option value="release_date-desc">Newest First</option>
                        <option value="release_date-asc">Oldest First</option>
                        <option value="title-asc">Title (A-Z)</option>
                        <option value="title-desc">Title (Z-A)</option>
                        <option value="duration-desc">Longest Duration</option>
                        <option value="duration-asc">Shortest Duration</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Active Filters -->
        @if($search || $selectedGenre !== 'all')
            <div class="pt-4 mt-4 border-t border-gray-800">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm text-gray-400">Active Filters:</span>
                    
                    @if($search)
                        <div class="bg-gray-800 rounded-full pl-3 pr-2 py-1.5 flex items-center text-sm">
                            <span class="text-gray-300 mr-2">Search: "{{ $search }}"</span>
                            <button wire:click="$set('search', '')" class="text-gray-400 hover:text-white p-1 rounded-full hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    
                    @if($selectedGenre !== 'all')
                        <div class="bg-gray-800 rounded-full pl-3 pr-2 py-1.5 flex items-center text-sm">
                            <span class="text-gray-300 mr-2">Genre: {{ $genreList->firstWhere('id', $selectedGenre)?->name }}</span>
                            <button wire:click="$set('selectedGenre', 'all')" class="text-gray-400 hover:text-white p-1 rounded-full hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Clear all filters -->
                    <button 
                        wire:click="$set('search', ''); $set('selectedGenre', 'all');" 
                        class="px-3 py-1.5 bg-primary/20 hover:bg-primary/30 text-primary hover:text-yellow-400 text-sm font-medium rounded-full flex items-center transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Clear All Filters
                    </button>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Tabs -->
    <div class="flex mb-6 border-b border-gray-800">
        <button 
            wire:click="setTab('now-showing')" 
            class="py-3 px-6 font-medium text-center {{ $activeTab === 'now-showing' ? 'text-primary border-b-2 border-primary' : 'text-gray-400 hover:text-white' }}"
        >
            Now Showing <span class="ml-2 bg-gray-800 text-white text-xs py-1 px-2 rounded-lg">{{ $nowShowingCount }}</span>
        </button>
        <button 
            wire:click="setTab('coming-soon')" 
            class="py-3 px-6 font-medium text-center {{ $activeTab === 'coming-soon' ? 'text-primary border-b-2 border-primary' : 'text-gray-400 hover:text-white' }}"
        >
            Coming Soon <span class="ml-2 bg-gray-800 text-white text-xs py-1 px-2 rounded-lg">{{ $comingSoonCount }}</span>
        </button>
    </div>
    
    <!-- Loading indicator (sebagai overlay) -->
    <div wire:loading class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-dark p-6 rounded-xl flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary mb-4"></div>
            <p class="text-white">Loading movies...</p>
        </div>
    </div>

    <!-- Results area -->
    <div>
        <!-- Results count and active filters -->
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div class="mb-2 sm:mb-0">
                <p class="text-gray-400">
                    Showing 
                    <span class="text-white font-medium">{{ $films->firstItem() ?? 0 }}-{{ $films->lastItem() ?? 0 }}</span> 
                    of 
                    <span class="text-white font-medium">{{ $films->total() }}</span> 
                    movies
                </p>
            </div>
            
            <!-- Active filters -->
            @if($search || $selectedGenre !== 'all')
                <div class="flex flex-wrap gap-2">
                    @if($search)
                        <div class="bg-gray-800 rounded-full pl-3 pr-2 py-1.5 flex items-center text-sm">
                            <span class="text-gray-300 mr-2">Search: "{{ $search }}"</span>
                            <button wire:click="$set('search', '')" class="text-gray-400 hover:text-white p-1 rounded-full hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    
                    @if($selectedGenre !== 'all')
                        <div class="bg-gray-800 rounded-full pl-3 pr-2 py-1.5 flex items-center text-sm">
                            <span class="text-gray-300 mr-2">Genre: {{ $genreList->firstWhere('id', $selectedGenre)?->name }}</span>
                            <button wire:click="$set('selectedGenre', 'all')" class="text-gray-400 hover:text-white p-1 rounded-full hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    
                    <!-- Clear all filters -->
                    <button 
                        wire:click="$set('search', ''); $set('selectedGenre', 'all');" 
                        class="px-3 py-1.5 bg-primary/20 hover:bg-primary/30 text-primary hover:text-yellow-400 text-sm font-medium rounded-full flex items-center transition-all"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Clear All Filters
                    </button>
                </div>
            @endif
        </div>
        
        <!-- Movies Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($films as $film)
                
                <div class="bg-dark rounded-xl overflow-hidden group hover:ring-2 hover:ring-primary/40 transition-all">
                    <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="block">
                        <!-- Status banner -->
                        @if($activeTab === 'now-showing')
                            <div class="bg-green-600 px-4 py-2 flex items-center justify-between">
                                <span class="font-bold text-white">Now Showing</span>
                                <span class="text-white/80 text-sm">Book Now</span>
                            </div>
                        @else
                            <div class="bg-primary px-4 py-2 flex items-center justify-between">
                                <span class="font-bold text-black">Coming {{ $film->release_date?->format('M d') }}</span>
                                <span class="text-black/80 text-sm">{{ $film->release_date?->diffForHumans() }}</span>
                            </div>
                        @endif
                        
                        <!-- Movie poster -->
                        <div class="p-4">
                            <div class="rounded-lg overflow-hidden mb-4 aspect-[2/3] bg-gray-800">
                                <img 
                                    src="{{ $film->poster_url }}" 
                                    alt="{{ $film->title }}"
                                    class="w-full h-full object-cover object-center"
                                    onerror="this.src='https://placehold.co/300x450/1A1A1A/FFCC00.png?text=BEEOSKOP'"
                                >
                            </div>
                            
                            <h3 class="text-lg font-bold text-white mb-1 line-clamp-1">{{ $film->title }}</h3>
                            
                            <div class="flex items-center text-sm text-gray-400 mb-2">
                                @if($film->year)
                                    <span>{{ $film->year }}</span>
                                @endif
                                
                                @if($film->duration)
                                    <span class="mx-2">•</span>
                                    <span>{{ $film->duration }} min</span>
                                @endif
                                
                                @if($film->genre)
                                    <span class="mx-2">•</span>
                                    <span>{{ $film->genre->name }}</span>
                                @endif
                            </div>
                            
                            <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ $film->sinopsis }}</p>
                        </div>
                    </a>
                    
                    <div class="flex justify-between items-center px-4 pb-4">
                        <button class="text-primary hover:text-yellow-400 font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            Trailer
                        </button>
                        
                        @if($activeTab === 'now-showing')
                            <a 
                                href="{{ route('movie.detail', $film->id) }}#showtimes" wire:navigate
                                class="px-3 py-1 bg-primary hover:bg-yellow-400 text-black font-medium rounded-lg transition text-sm"
                        >
                                Tickets
                            </a>
                        @else
                            <button class="text-white hover:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-dark rounded-xl p-8 text-center">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    
                    @if($search || $selectedGenre !== 'all')
                        <h3 class="text-xl font-bold text-white mb-1">No movies match your filters</h3>
                        <p class="text-gray-400 mb-4">Try changing your search or filter criteria</p>
                        <button 
                            wire:click="$set('search', ''); $set('selectedGenre', 'all');" 
                            class="px-4 py-2 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition"
                        >
                            Clear All Filters
                        </button>
                    @else
                        @if($activeTab === 'now-showing')
                            <h3 class="text-xl font-bold text-white mb-1">No Movies Currently Showing</h3>
                            <p class="text-gray-400">Check out our Coming Soon section for upcoming releases</p>
                        @else
                            <h3 class="text-xl font-bold text-white mb-1">No Upcoming Movies</h3>
                            <p class="text-gray-400">Check back later for future releases</p>
                        @endif
                    @endif
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $films->links() }}
        </div>
    </div>
</div>
