<div>
    <!-- Hero Section -->
    <section class="relative mb-8">
        <div class="h-[70vh] relative overflow-hidden">
            <!-- Backdrop Image -->
            <div class="absolute inset-0">
                <img 
                    src="{{ $film->poster_url }}" 
                    alt="{{ $film->title }}" 
                    class="w-full h-full object-cover object-center"
                    onerror="this.src='https://placehold.co/1600x900/121212/FFCC00.png?text=BEEOSKOP'"
                >
                <!-- Gradient Overlay for better readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-dark via-dark/80 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-dark/90 via-dark/50 to-transparent"></div>
            </div>
            
            <!-- Film Info -->
            <div class="container mx-auto px-4 md:px-6 relative h-full flex items-end pb-8 z-10">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-end w-full">
                    <!-- Poster Column -->
                    <div class="hidden md:block">
                        <div class="rounded-lg overflow-hidden shadow-2xl border border-gray-800 aspect-[2/3] mb-4">
                            <img 
                                src="{{ $film->poster_url }}" 
                                alt="{{ $film->title }} Poster" 
                                class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/300x450/121212/FFCC00.png?text=BEEOSKOP'"
                            >
                        </div>
                    </div>
                    
                    <!-- Details Column -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <!-- Film Title and Basic Info -->
                        <div class="mb-4">
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2">{{ $film->title }}</h1>
                            
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-300 mb-4">
                                @if($film->year)
                                    <span>{{ $film->year }}</span>
                                    <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                @endif
                                
                                @if($film->duration)
                                    <span>{{ $film->duration }} min</span>
                                    <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                @endif
                                
                                @if($film->genre)
                                    <span>{{ $film->genre->name }}</span>
                                @endif
                                
                                @if($film->release_date)
                                    <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                                    @if($film->release_date->isPast())
                                        <span>Released {{ $film->release_date->format('M d, Y') }}</span>
                                    @else
                                        <span class="text-primary">Coming {{ $film->release_date->format('M d, Y') }}</span>
                                    @endif
                                @endif
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex flex-wrap gap-3 mb-6">
                                @if($film->is_showing && count($availableDates) > 0)
                                    <a href="#showtimes" class="px-6 py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                        Book Tickets
                                    </a>
                                @endif
                                
                                <button wire:click="openTrailer" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-lg transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                    Watch Trailer
                                </button>
                                
                                <button class="p-3 bg-gray-800/80 hover:bg-gray-700 text-white rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                
                                <button class="p-3 bg-gray-800/80 hover:bg-gray-700 text-white rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Synopsis -->
                            <div class="mb-4">
                                <h2 class="text-lg font-semibold text-white mb-2">Synopsis</h2>
                                <p class="text-gray-300 max-w-3xl">
                                    {{ $film->sinopsis }}
                                </p>
                            </div>
                            
                            <!-- Additional Info -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm max-w-3xl">
                                @if($film->producer)
                                    <div>
                                        <span class="block text-gray-400">Producer</span>
                                        <span class="text-white">{{ $film->producer }}</span>
                                    </div>
                                @endif
                                
                                <div>
                                    <span class="block text-gray-400">Status</span>
                                    @if($film->is_showing)
                                        <span class="text-green-400">Now Showing</span>
                                    @else
                                        @if($film->release_date && $film->release_date->isFuture())
                                            <span class="text-primary">Coming Soon</span>
                                        @else
                                            <span class="text-gray-300">Not Showing</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Showtimes Section -->
    @if($film->is_showing && count($availableDates) > 0)
        <section id="showtimes" class="mb-12 scroll-mt-24">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-white">Showtimes & Tickets</h2>
                    
                    <!-- Price Info Badge -->
                    <div class="flex items-center bg-dark border border-gray-700 rounded-full px-4 py-1.5">
                        <span class="text-primary font-medium mr-2">Price:</span>
                        <span class="text-white font-medium">
                            @if($isWeekend)
                                Rp 45.000 
                                <span class="ml-1 text-xs px-2 py-0.5 bg-blue-900/30 text-blue-300 rounded-full">Weekend</span>
                            @else
                                Rp 30.000
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- Date Selection -->
                <div class="mb-8">
                    <div class="flex overflow-x-auto py-2 gap-3 no-scrollbar">
                        @foreach($availableDates as $date)
                            <button 
                                wire:click="$set('selectedDate', '{{ $date->format('Y-m-d') }}')"
                                class="flex flex-col items-center px-4 py-3 rounded-lg min-w-[80px] transition-colors border {{ $selectedDate == $date->format('Y-m-d') ? 'bg-primary border-primary text-black' : 'bg-dark border-gray-700 text-white hover:bg-gray-800' }}"
                            >
                                <span class="text-xs font-medium {{ $selectedDate == $date->format('Y-m-d') ? 'text-black' : 'text-gray-400' }}">
                                    {{ $date->format('D') }}
                                </span>
                                <span class="text-xl font-bold">{{ $date->format('d') }}</span>
                                <span class="text-xs {{ $selectedDate == $date->format('Y-m-d') ? 'text-black' : 'text-gray-400' }}">
                                    {{ $date->format('M') }}
                                </span>
                                
                                <!-- Weekend indicator -->
                                @if($date->isWeekend())
                                    <span class="mt-1 text-[10px] px-1.5 py-0.5 rounded-sm {{ $selectedDate == $date->format('Y-m-d') ? 'bg-black/30 text-black' : 'bg-blue-900/30 text-blue-300' }}">
                                        WEEKEND
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <!-- Theater Listings -->
                <div class="space-y-6">
                    @forelse($studioShowtimes as $studioId => $studioData)
                        <div class="bg-dark rounded-xl p-4 border border-gray-800">
                            <h3 class="text-white font-bold mb-3">{{ $studioData['studio']->name }}</h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($studioData['times'] as $jadwal)
                                    @php
                                    // Gunakan property is_expired yang sudah dihitung di controller
                                    $isExpired = $jadwal->is_expired;
                                    $showDateTime = \Carbon\Carbon::parse($jadwal->date)->setTimeFromTimeString($jadwal->time_start)->toISOString();
                                    @endphp
                                    
                                    <a 
                                        href="{{ !$isExpired ? route('seat.selection', $jadwal->id) : '#' }}" wire:navigate
                                        class="group relative px-4 py-2 {{ !$isExpired ? 'bg-gray-800 hover:bg-primary hover:text-black' : 'bg-gray-800/50 text-gray-500 cursor-not-allowed' }} font-medium rounded-lg transition"
                                        @if($isExpired) 
                                            onclick="event.preventDefault()" 
                                            aria-disabled="true"
                                        @endif
                                        data-showtime="{{ $showDateTime }}"
                                        data-jadwal-id="{{ $jadwal->id }}"
                                    >
                                        {{ \Carbon\Carbon::parse($jadwal->time_start)->format('H:i') }}
                                        
                                        <!-- Badge untuk jadwal yang sudah lewat -->
                                        @if($isExpired)
                                            <span class="expired-badge absolute -top-2 -right-2 px-1.5 py-0.5 bg-red-900/80 text-red-300 text-[9px] rounded-full">EXPIRED</span>
                                        @endif
                                        
                                        <!-- Tooltip untuk harga -->
                                        <span class="absolute -bottom-14 left-1/2 -translate-x-1/2 w-32 px-2 py-1.5 bg-white rounded text-xs text-black text-center font-medium opacity-0 invisible group-hover:opacity-100 group-hover:visible transition pointer-events-none shadow-lg z-10">
                                            <span class="block">Price:</span>
                                            <span class="font-bold">Rp {{ number_format($jadwal->price, 0, ',', '.') }}</span>
                                            <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-white rotate-45"></div>
                                        </span>
                                        
                                        <!-- Tooltip untuk jadwal yang sudah lewat -->
                                        @if($isExpired)
                                            <span class="absolute -bottom-14 left-1/2 -translate-x-1/2 w-40 px-2 py-1.5 bg-red-900 rounded text-xs text-white text-center font-medium opacity-0 invisible group-hover:opacity-100 group-hover:visible transition pointer-events-none shadow-lg z-10">
                                                This show has already started
                                                <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-red-900 rotate-45"></div>
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="bg-dark rounded-xl p-8 border border-gray-800 text-center">
                            <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-1">No Showtimes Available</h3>
                            <p class="text-gray-400">There are no showtimes available for this date. Please select another date or check back later.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @elseif($film->release_date && $film->release_date->isFuture())
        <section class="mb-12">
            <div class="container mx-auto px-4 md:px-6">
                <div class="bg-dark rounded-xl p-8 border border-gray-800 text-center">
                    <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">Coming Soon!</h3>
                    <p class="text-gray-400 mb-2">This film will be released on {{ $film->release_date->format('F d, Y') }}</p>
                    <p class="text-gray-400">Check back later for showtimes.</p>
                </div>
            </div>
        </section>
    @endif
    
    <!-- Film Details Section -->
    <section class="mb-12">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Additional Details -->
                <div class="lg:col-span-2">
                    <div class="bg-dark rounded-xl p-6 border border-gray-800">
                        <h2 class="text-xl font-bold text-white mb-6">About the Movie</h2>
                        
                        <div class="prose prose-invert max-w-none">
                            <p class="text-gray-300">
                                {{ $film->sinopsis }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Poster and Recommendations -->
                <div>
                    <!-- Mobile Poster -->
                    <div class="md:hidden mb-6">
                        <div class="rounded-lg overflow-hidden shadow-lg border border-gray-800 aspect-[2/3]">
                            <img 
                                src="{{ $film->poster_url }}" 
                                alt="{{ $film->title }} Poster" 
                                class="w-full h-full object-cover"
                                onerror="this.src='https://placehold.co/300x450/121212/FFCC00.png?text=BEEOSKOP'"
                            >
                        </div>
                    </div>
                    
                    <!-- Film Info Card -->
                    <div class="bg-dark rounded-xl p-6 border border-gray-800 mb-6">
                        <h2 class="text-xl font-bold text-white mb-4">Film Info</h2>
                        
                        <div class="space-y-3">
                            @if($film->release_date)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Release Date</span>
                                    <span class="text-white">{{ $film->release_date->format('M d, Y') }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Duration</span>
                                <span class="text-white">{{ $film->duration ?? 0 }} minutes</span>
                            </div>
                            
                            @if($film->genre)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Genre</span>
                                    <span class="text-white">{{ $film->genre->name }}</span>
                                </div>
                            @endif
                            
                            @if($film->producer)
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Producer</span>
                                    <span class="text-white">{{ $film->producer }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <span class="text-gray-400">Status</span>
                                <span class="{{ $film->is_showing ? 'text-green-400' : 'text-yellow-400' }}">
                                    {{ $film->is_showing ? 'Now Showing' : ($film->release_date && $film->release_date->isFuture() ? 'Coming Soon' : 'Not Showing') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Movies Card - This would be populated with actual related films if we had the data -->
                    <!-- <div class="bg-dark rounded-xl p-6 border border-gray-800">
                        <h2 class="text-xl font-bold text-white mb-4">You May Also Like</h2>
                        <div class="space-y-4">
                            Sample recommendations here
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trailer Modal -->
    <div
        x-data="{ open: @entangle('trailerOpen').live }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
        x-cloak
    >
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="open = false"
            class="relative w-full max-w-4xl bg-dark rounded-2xl overflow-hidden shadow-2xl"
        >
            <!-- Close button -->
            <button 
                @click="open = false" 
                class="absolute top-4 right-4 z-10 p-2 bg-black/50 rounded-full text-white hover:bg-black/70 transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Video container with 16:9 aspect ratio -->
            <div class="relative aspect-video bg-black">
                <!-- This would be replaced with an actual trailer embed -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center mx-auto mb-4">
                            <div class="w-16 h-16 rounded-full bg-primary/40 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">{{ $film->title }} - Official Trailer</h3>
                        <p class="text-gray-400">This is a placeholder. In a real app, the actual trailer would be embedded here.</p>
                    </div>
                </div>
                
                <!-- The actual video iframe would be here, like: -->
                <iframe src="https://www.youtube.com/embed/TRAILER_ID" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mengecek jadwal yang sudah expired secara real-time
    function checkExpiredShowtimes() {
        const now = new Date();
        
        document.querySelectorAll('[data-showtime]').forEach(el => {
            const showtime = new Date(el.getAttribute('data-showtime'));
            
            if (now > showtime) {
                // Tandai sebagai expired
                el.classList.add('bg-gray-800/50', 'text-gray-500', 'cursor-not-allowed');
                el.classList.remove('bg-gray-800', 'hover:bg-primary', 'hover:text-black');
                el.setAttribute('onclick', 'event.preventDefault()');
                el.setAttribute('aria-disabled', 'true');
                el.href = '#';
                
                // Tambahkan badge jika belum ada
                if (!el.querySelector('.expired-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'expired-badge absolute -top-2 -right-2 px-1.5 py-0.5 bg-red-900/80 text-red-300 text-[9px] rounded-full';
                    badge.textContent = 'EXPIRED';
                    el.appendChild(badge);
                }
            }
        });
    }
    
    // Panggil fungsi saat halaman dimuat
    checkExpiredShowtimes();
    
    // Update setiap menit
    setInterval(checkExpiredShowtimes, 60000);
    
    // Listen untuk update Livewire
    document.addEventListener('livewire:update', checkExpiredShowtimes);
});
</script>

<style>
    /* Style untuk tombol waktu yang sudah lewat */
    .cursor-not-allowed {
        pointer-events: all !important; /* Memungkinkan hover untuk tooltip */
        cursor: not-allowed !important;
    }
    
    /* Styling untuk badge expired */
    .expired-badge {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
</style>
</div>

<!-- Tambahkan script ini di bagian bawah file detail-film.blade.php -->
