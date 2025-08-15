<div>
    <!-- Hero Section with Featured Film Carousel -->
    <section class="relative -mt-8 mb-8">
        <div x-data="{ activeSlide: 0 }" class="relative">
            <!-- Slides -->
            <div class="relative h-[70vh] overflow-hidden rounded-2xl shadow-xl">
                @forelse($featuredFilms as $index => $film)
                    <div 
                        x-show="activeSlide === {{ $index }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute inset-0"
                    >
                        <!-- Gradient overlay for readability -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent opacity-90 z-10"></div>
                        
                        <!-- Movie backdrop -->
                        <img 
                            src="{{ $film->poster_url }}" 
                            alt="{{ $film->title }}" 
                            class="w-full h-full object-cover object-center"
                            onerror="this.src='https://placehold.co/1200x600/121212/FFCC00.png?text=BEEOSKOP'"
                        >
                        
                        <!-- Content overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 z-20">
                            <div class="max-w-4xl">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2 py-1 bg-primary rounded text-xs font-bold text-black">NEW RELEASE</span>
                                    @if($film->age_rating)
                                        <span class="px-2 py-1 bg-gray-800 rounded text-xs font-bold">{{ $film->age_rating }}+</span>
                                    @endif
                                </div>
                                
                                <h1 class="text-3xl md:text-5xl font-bold text-white mb-2">{{ $film->title }}</h1>
                                
                                <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                                    <span>{{ $film->duration ?? 0 }} min</span>
                                    <span>•</span>
                                    <span>{{ $film->year }}</span>
                                    @if($film->genre)
                                        <span>•</span>
                                        <span>{{ $film->genre->name }}</span>
                                    @endif
                                </div>
                                
                                <p class="text-gray-300 mb-6 max-w-2xl line-clamp-2">{{ $film->sinopsis }}</p>
                                
                                <div class="flex flex-wrap gap-3">
                                    <a href="#" class="px-6 py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                        </svg>
                                        Watch Trailer
                                    </a>
                                    <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-lg transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="absolute inset-0 flex items-center justify-center bg-dark">
                        <div class="text-center p-6">
                            <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-white mb-2">Coming Soon!</h2>
                            <p class="text-gray-400">Stay tuned for exciting new releases</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Slider controls -->
            @if(count($featuredFilms) > 1)
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30 flex items-center space-x-2">
                    @foreach($featuredFilms as $index => $film)
                        <button 
                            @click="activeSlide = {{ $index }}" 
                            class="w-2 h-2 rounded-full transition-all duration-300"
                            :class="activeSlide === {{ $index }} ? 'bg-primary w-6' : 'bg-gray-400'"
                        ></button>
                    @endforeach
                </div>
                
                <!-- Arrow controls -->
                <button 
                    @click="activeSlide = activeSlide === 0 ? {{ count($featuredFilms) - 1 }} : activeSlide - 1"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-sm text-white flex items-center justify-center transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button 
                    @click="activeSlide = activeSlide === {{ count($featuredFilms) - 1 }} ? 0 : activeSlide + 1"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 h-10 w-10 rounded-full bg-black/30 hover:bg-black/50 backdrop-blur-sm text-white flex items-center justify-center transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                <div 
                    x-init="setInterval(() => { activeSlide = activeSlide === {{ count($featuredFilms) - 1 }} ? 0 : activeSlide + 1 }, 6000)"
                ></div>
            @endif
        </div>
    </section>

    <!-- Now Showing Section -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Now Showing</h2>
                <p class="text-gray-400">Catch these movies in theaters now</p>
            </div>
            <a href="{{ route('movies') }}" wire:navigate class="text-primary hover:text-yellow-300 font-medium flex items-center">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @forelse($nowShowingFilms as $film)
                <div class="relative group">
                    <!-- Movie poster with overlay on hover -->
                    <div class="relative overflow-hidden rounded-xl aspect-[2/3]">
                        <!-- Image -->
                        <img 
                            src="{{ $film->poster_url }}" 
                            alt="{{ $film->title }}"
                            class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-300"
                            onerror="this.src='https://placehold.co/300x450/121212/FFCC00.png?text=BEEOSKOP'"
                        >
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="bg-primary hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-lg flex items-center space-x-1 transform -translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Book Now</span>
                            </a>
                        </div>
                        
                        <!-- Age rating -->
                        @if($film->age_rating)
                            <div class="absolute top-2 left-2 px-2 py-1 bg-black/70 rounded text-xs font-bold">
                                {{ $film->age_rating }}+
                            </div>
                        @endif
                    </div>
                    
                    <!-- Movie info -->
                    <div class="mt-3">
                        <h3 class="text-white font-medium truncate">{{ $film->title }}</h3>
                        <div class="flex items-center space-x-2 text-sm text-gray-400">
                            <span>{{ $film->duration ?? 0 }} min</span>
                            @if($film->genre)
                                <span>•</span>
                                <span class="truncate">{{ $film->genre->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center p-8 bg-dark/50 rounded-xl">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zm7-10a1 1 0 01.707.293l4 4a1 1 0 010 1.414l-4 4A1 1 0 0110 10V8H4a1 1 0 110-2h6V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">No Movies Available</h3>
                    <p class="text-gray-400">Check back soon for exciting new releases</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- Coming Soon Section -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Coming Soon</h2>
                <p class="text-gray-400">Movies to look forward to</p>
            </div>
            <a href="{{ route('movies') }}" wire:navigate class="text-primary hover:text-yellow-300 font-medium flex items-center">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($comingSoonFilms as $film)
                <div class="bg-dark rounded-xl overflow-hidden group hover:ring-2 hover:ring-primary/40 transition-all">
                    <!-- Make the entire film card clickable -->
                    <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="block">
                        <!-- Release date banner -->
                        <div class="bg-primary px-4 py-2 flex items-center justify-between">
                            <span class="font-bold text-black">Coming {{ $film->release_date->format('M d') }}</span>
                            <span class="text-black text-sm">{{ $film->release_date->diffForHumans() }}</span>
                        </div>
                        
                        <!-- Movie poster -->
                        <div class="p-4">
                            <div class="rounded-lg overflow-hidden mb-4 aspect-[16/9]">
                                <img 
                                    src="{{ $film->poster_url }}" 
                                    alt="{{ $film->title }}"
                                    class="w-full h-full object-cover object-center"
                                    onerror="this.src='https://placehold.co/400x225/1A1A1A/FFCC00.png?text=BEEOSKOP'"
                                >
                            </div>
                            
                            <h3 class="text-lg font-bold text-white mb-1">{{ $film->title }}</h3>
                            
                            <div class="flex items-center text-sm text-gray-400 mb-3">
                                <span>{{ $film->duration ?? 0 }} min</span>
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
                        
                        <button class="text-white hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center p-8 bg-dark/50 rounded-xl">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">No Upcoming Movies</h3>
                    <p class="text-gray-400">Check back later for future releases</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- Genres Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-white mb-6">Browse by Genre</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($popularGenres as $genre)
                <a href="#" class="bg-dark hover:bg-dark/80 rounded-xl p-5 text-center transition-transform hover:scale-105">
                    <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            @switch($loop->index % 6)
                                @case(0)
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    @break
                                @case(1)
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd" />
                                    @break
                                @case(2)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    @break
                                @case(3)
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    @break
                                @case(4)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                    @break
                                @default
                                    <path d="M2 5.5a3.5 3.5 0 115.898 2.549 5.507 5.507 0 013.034 4.084.75.75 0 11-1.482.235 4.001 4.001 0 00-7.9 0 .75.75 0 01-1.482-.236A5.507 5.507 0 013.102 8.05 3.49 3.49 0 012 5.5zM11 4a.75.75 0 100 1.5 1.5 1.5 0 01.666 2.844.75.75 0 00-.416.672v.352a.75.75 0 00.574.73c1.2.289 2.162 1.2 2.522 2.372a.75.75 0 101.434-.44 5.01 5.01 0 00-2.56-3.012A3 3 0 0011 4z" />
                            @endswitch
                        </svg>
                    </div>
                    <h3 class="text-white font-medium">{{ $genre->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $genre->films_count }} movies</p>
                </a>
            @empty
                <div class="col-span-full text-center p-6">
                    <p class="text-gray-400">No genres available</p>
                </div>
            @endforelse
        </div>
    </section>
    
    <!-- Promotion Section -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-primary/20 to-dark border border-primary/30 rounded-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="inline-block bg-primary/20 px-3 py-1 rounded-full text-primary text-sm font-medium mb-4">
                        SPECIAL OFFER
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Midweek Movie Madness</h2>
                    <p class="text-gray-300 mb-6">Get 20% off on all tickets booked for Tuesday and Wednesday screenings. Bring your friends and enjoy your favorite movies at discounted prices!</p>
                    <div>
                        <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-primary hover:bg-yellow-400 transition-colors text-black font-bold rounded-lg">
                            Book Tickets
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="hidden md:block relative">
                    <img 
                        src="https://images.unsplash.com/photo-1485846234645-a62644f84728?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                        alt="Cinema Experience" 
                        class="h-full w-full object-cover"
                        onerror="this.src='https://placehold.co/800x600/121212/FFCC00.png?text=CINEMA'"
                    >
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-dark to-transparent"></div>
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-full w-20 h-20 bg-primary/20 flex items-center justify-center">
                        <div class="rounded-full w-16 h-16 bg-primary/40 flex items-center justify-center">
                            <div class="rounded-full w-12 h-12 bg-primary flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
