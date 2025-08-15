<div class="py-4">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white">Film Screenings</h1>
                <p class="mt-1 text-sm text-gray-400">Manage screening schedules for movies across your theaters</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button 
                    wire:click="openForm('create')" 
                    class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors flex items-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Screening
                </button>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-dark/60 border border-gray-800 rounded-xl p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-auto flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        wire:model.live.debounce.300ms="search" 
                        class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white placeholder-gray-400 focus:outline-none focus:border-primary"
                        placeholder="Search movies..."
                    />
                </div>
            </div>
            <div class="w-full sm:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </div>
                    <input 
                        type="date" 
                        wire:model.live="dateFilter" 
                        class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white focus:outline-none focus:border-primary"
                    />
                </div>
            </div>
            <div class="w-full sm:w-auto">
                <select 
                    wire:model.live="studioFilter" 
                    class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:border-primary block w-full p-2.5"
                >
                    <option value="">All Studios</option>
                    @foreach($studios as $studio)
                        <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <select 
                    wire:model.live="filmFilter" 
                    class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:border-primary block w-full p-2.5"
                >
                    <option value="">All Movies</option>
                    @foreach($films as $film)
                        <option value="{{ $film->id }}">{{ $film->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- View Selector -->
        <div class="mt-4 border-t border-gray-800 pt-4">
            <div class="flex items-center justify-between">
                <div class="flex space-x-2">
                    <button 
                        wire:click="$set('viewMode', 'list')" 
                        class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ $viewMode === 'list' ? 'bg-primary text-black' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                    >
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            List
                        </div>
                    </button>
                    <button 
                        wire:click="$set('viewMode', 'timeline')" 
                        class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ $viewMode === 'timeline' ? 'bg-primary text-black' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                    >
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Timeline
                        </div>
                    </button>
                    <button 
                        wire:click="$set('viewMode', 'calendar')" 
                        class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ $viewMode === 'calendar' ? 'bg-primary text-black' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}"
                    >
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                            </svg>
                            Calendar
                        </div>
                    </button>
                </div>
                
                @if($viewMode === 'calendar')
                    <div class="flex items-center space-x-2">
                        <button 
                            wire:click="setToday" 
                            class="px-3 py-1.5 text-sm font-medium bg-gray-800 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors"
                        >
                            Today
                        </button>
                        <button 
                            wire:click="previousWeek" 
                            class="p-1.5 bg-gray-800 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </button>
                        <span class="text-white">{{ $currentWeekStart->format('M d') }} - {{ $currentWeekStart->copy()->addDays(6)->format('M d, Y') }}</span>
                        <button 
                            wire:click="nextWeek" 
                            class="p-1.5 bg-gray-800 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Content based on view mode -->
    @if($viewMode === 'list')
        <!-- List View -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Movie
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Studio
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Duration
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse ($screenings as $screening)
                            <tr class="hover:bg-gray-900/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start flex-col">
                                        <span class="text-sm font-medium text-white">{{ $screening->date->format('M d, Y') }}</span>
                                        <span class="text-sm text-gray-300 flex items-center mt-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $screening->time_start->format('H:i') }} - {{ $screening->time_end->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-7 rounded overflow-hidden bg-gray-800 mr-3 flex-shrink-0">
                                            @if($screening->film->poster_url)
                                                <img src="{{ $screening->film->poster_url }}" class="h-full w-full object-cover" alt="{{ $screening->film->title }}" />
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gray-700 text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $screening->film->title }}</div>
                                            <div class="text-xs text-gray-400">{{ $screening->film->genre->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center bg-blue-900/20 text-blue-300 px-2 py-1 rounded-lg text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 6a2 2 0 002-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                        </svg>{{ $screening->studio->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    @php
                                        $duration = $screening->film->duration;
                                        $hours = floor($duration / 60);
                                        $minutes = $duration % 60;
                                        $durationText = ($hours > 0 ? $hours . 'h ' : '') . $minutes . 'm';
                                    @endphp
                                    {{ $durationText }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-medium text-green-400">
                                        Rp {{ number_format($screening->price, 0, ',', '.') }}
                                    </span>
                                    
                                    @if(Carbon\Carbon::parse($screening->date)->isWeekend())
                                        <span class="inline-flex items-center ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-900/20 text-blue-300">
                                            Weekend
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <button 
                                            wire:click="openForm('edit', {{ $screening->id }})" 
                                            class="text-blue-400 hover:text-blue-300"
                                            title="Edit Screening"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button 
                                            wire:click="confirmDelete({{ $screening->id }})" 
                                            class="text-red-400 hover:text-red-300"
                                            title="Delete Screening"
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
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                                        </svg>
                                        <span class="text-lg font-medium">No screenings found</span>
                                        <p class="mt-1 text-sm">Adjust your filters or create a new screening</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($screenings->hasPages())
                <div class="px-6 py-3 border-t border-gray-800">
                    {{ $screenings->links('livewire.custom-pagination') }}
                </div>
            @endif
        </div>
    @elseif($viewMode === 'timeline')
        <!-- Timeline View -->
        @if(empty($dateFilter))
            <div class="bg-dark/60 border border-gray-800 rounded-xl p-8 text-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-white mb-2">Please Select a Date</h3>
                <p class="max-w-md mx-auto">Timeline view requires a specific date to display screenings. Please use the date filter above to select a date.</p>
            </div>
        @else
            <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
                <div class="p-4 border-b border-gray-800 flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">
                        Screenings for {{ Carbon\Carbon::parse($dateFilter)->format('l, F j, Y') }}
                    </h3>
                    <div class="text-xs text-gray-400 flex items-center">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500/50 mr-1"></span>
                        Scheduled screening
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <div class="py-6 px-4 min-w-max">
                        <!-- Time indicators -->
                        <div class="flex border-b border-gray-800 pb-2">
                            <div class="w-36 flex-shrink-0"></div>
                            <div class="flex-1 flex">
                                @for ($hour = 8; $hour <= 23; $hour++)
                                    <div class="w-[100px] text-xs text-gray-400 text-center">
                                        {{ sprintf('%02d:00', $hour) }}
                                    </div>
                                @endfor
                            </div>
                        </div>
                        
                        <!-- Studios with screenings -->
                        @forelse ($timelineScreenings as $studioId => $data)
                            <div class="flex py-4 border-b border-gray-800/50 last:border-b-0">
                                <div class="w-36 flex-shrink-0 pr-4">
                                    <div class="bg-gray-800/60 py-2 px-3 rounded-lg text-white font-medium text-sm truncate">
                                        Studio {{ $data['studio']->name }}
                                    </div>
                                </div>
                                <div class="flex-1 relative" style="height: 50px;">
                                    <!-- Timeline grid -->
                                    <div class="absolute inset-0 flex pointer-events-none">
                                        @for ($hour = 8; $hour <= 23; $hour++)
                                            <div class="w-[100px] border-r border-gray-800/30 last:border-r-0"></div>
                                        @endfor
                                    </div>
                                    
                                    <!-- Screenings -->
                                    @foreach ($data['screenings'] as $screening)
                                        @php
                                            $startPosition = $this->calculatePosition($screening->time_start->format('H:i'));
                                            $height = $this->calculateHeight($screening->time_start->format('H:i'), $screening->time_end->format('H:i'));
                                            $filmTitle = $screening->film->title;
                                            $timeRange = $screening->time_start->format('H:i') . ' - ' . $screening->time_end->format('H:i');
                                            
                                            // Generate a consistent color based on the film id
                                            $hue = ($screening->film_id * 75) % 360;
                                            $bgColor = "hsla($hue, 70%, 40%, 0.3)";
                                            $borderColor = "hsla($hue, 70%, 50%, 0.5)";
                                        @endphp
                                        
                                        <div 
                                            class="absolute rounded-md border p-2 cursor-pointer hover:shadow-lg transition-shadow overflow-hidden"
                                            style="left: {{ $startPosition }}px; height: 46px; width: {{ $height }}px; background-color: {{ $bgColor }}; border-color: {{ $borderColor }};"
                                            title="{{ $filmTitle }} ({{ $timeRange }})"
                                            wire:click="openForm('edit', {{ $screening->id }})"
                                        >
                                            <div class="text-xs font-medium text-white truncate">{{ $filmTitle }}</div>
                                            <div class="text-xs text-gray-100/80 truncate">{{ $timeRange }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-lg font-medium">No screenings scheduled for this day</span>
                                <p class="mt-1 text-sm">Create screenings to see them in the timeline view</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    @elseif($viewMode === 'calendar')
        <!-- Calendar View -->
        <div class="bg-dark/60 border border-gray-800 rounded-xl overflow-hidden">
            <div class="grid grid-cols-7 border-b border-gray-800">
                @foreach ($calendarDays as $day)
                    <div class="p-4 text-center border-r border-gray-800 last:border-r-0 {{ $day['isToday'] ? 'bg-primary/10' : '' }}">
                        <div class="text-xs text-gray-400 uppercase mb-1">{{ $day['dayName'] }}</div>
                        <div class="{{ $day['isToday'] ? 'text-primary font-semibold' : 'text-white' }}">{{ $day['day'] }}</div>
                    </div>
                @endforeach
            </div>
            
            <div class="grid grid-cols-7 min-h-[400px] divide-x divide-gray-800">
                @foreach ($calendarDays as $day)
                    <div class="p-3 {{ $day['isToday'] ? 'bg-primary/5' : '' }}">
                        @php
                            $dayScreenings = $this->getScreeningsForDay($day['date']);
                        @endphp
                        
                        @if($dayScreenings->count() > 0)
                            <div class="space-y-2">
                                @foreach($dayScreenings as $screening)
                                    <div 
                                        class="bg-gray-800/60 rounded-lg p-3 text-sm border-l-2 cursor-pointer hover:bg-gray-800 transition-colors"
                                        style="border-color: {{ '#' . substr(md5($screening->film_id), 0, 6) }};"
                                        wire:click="openForm('edit', {{ $screening->id }})"
                                    >
                                        <div class="font-medium text-white truncate">{{ $screening->film->title }}</div>
                                        <div class="flex items-center mt-1 text-xs text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $screening->time_start->format('H:i') }} - {{ $screening->time_end->format('H:i') }}
                                        </div>
                                        <div class="flex items-center mt-1 text-xs text-blue-300/80">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                            Studio {{ $screening->studio->name }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="h-full flex items-center justify-center">
                                <div class="text-xs text-gray-500">No screenings</div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Screening Form Modal -->
    <div x-data="{ show: @entangle('isFormVisible') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                @click="$wire.closeForm()"
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
                class="relative bg-dark border border-gray-700 rounded-xl text-white w-full max-w-lg transform transition-all sm:my-8"
            >
                <div class="px-6 pt-5 pb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-white">
                            {{ $isEditMode ? 'Edit Screening' : 'Add New Screening' }}
                        </h3>
                        <button wire:click="closeForm" class="text-gray-400 hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="saveScreening">
                        <div class="space-y-4">
                            <!-- Movie Selection -->
                            <div>
                                <label for="filmId" class="block text-sm font-medium text-gray-300 mb-1">
                                    Movie <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="filmId" 
                                    wire:model.live="filmId" 
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                >
                                    <option value="">Select a movie</option>
                                    @foreach($films as $film)
                                        <option value="{{ $film->id }}">{{ $film->title }} ({{ floor($film->duration / 60) }}h {{ $film->duration % 60 }}m)</option>
                                    @endforeach
                                </select>
                                @error('filmId') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Studio Selection -->
                            <div>
                                <label for="studioId" class="block text-sm font-medium text-gray-300 mb-1">
                                    Studio <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="studioId" 
                                    wire:model.blur="studioId" 
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                >
                                    <option value="">Select a studio</option>
                                    @foreach($studios as $studio)
                                        <option value="{{ $studio->id }}">Studio {{ $studio->name }}</option>
                                    @endforeach
                                </select>
                                @error('studioId') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Date Selection -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-300 mb-1">
                                    Date <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </div>
                                    <input 
                                        type="date" 
                                        id="date" 
                                        wire:model.blur="date" 
                                        class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white focus:outline-none focus:border-primary"
                                    />
                                </div>
                                @error('date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Time Selection -->
                            <div>
                                <label for="timeStart" class="block text-sm font-medium text-gray-300 mb-1">
                                    Start Time <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </div>
                                    <input 
                                        type="time" 
                                        id="timeStart" 
                                        wire:model.live="timeStart" 
                                        class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white focus:outline-none focus:border-primary"
                                    />
                                </div>
                                @error('timeStart') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- End Time (Read-only, calculated automatically) -->
                            @if($selectedFilmDuration > 0 && $timeStart)
                                <div class="bg-gray-800/50 p-4 rounded-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-white">Film Duration: {{ floor($selectedFilmDuration / 60) }}h {{ $selectedFilmDuration % 60 }}m</h4>
                                            <p class="text-sm text-gray-400 mt-1">End Time: <span class="text-white">{{ $timeEnd }}</span></p>
                                            <input type="hidden" wire:model="timeEnd" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Price Input -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-300 mb-1">
                                    Price (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-gray-400">Rp</span>
                                    </div>
                                    <input 
                                        type="number" 
                                        id="price" 
                                        wire:model="price" 
                                        class="pl-10 pr-4 py-2 w-full bg-gray-800 border border-gray-700 rounded-lg text-sm text-white focus:outline-none focus:border-primary"
                                        min="0"
                                        step="1000"
                                    />
                                </div>
                                <div class="mt-1 text-xs text-gray-400">
                                    Standard: Rp 30.000 (Weekday) | Rp 45.000 (Weekend)
                                </div>
                                @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Schedule Notice -->
                            <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-800">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs text-gray-400">
                                        End time is calculated automatically based on the movie's duration.
                                        Ensure there are no scheduling conflicts for the selected studio.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button 
                                type="button"
                                wire:click="closeForm" 
                                class="px-4 py-2 bg-gray-800 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 bg-primary text-black font-medium rounded-lg hover:bg-amber-400 transition-colors focus:outline-none"
                                wire:loading.attr="disabled"
                                {{ !$filmId ? 'disabled' : '' }}
                            >
                                <span wire:loading.remove wire:target="saveScreening">
                                    {{ $isEditMode ? 'Update Screening' : 'Create Screening' }}
                                </span>
                                <span wire:loading wire:target="saveScreening" class="flex items-center">
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
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-white mb-2">
                            Delete Screening
                        </h3>
                        <p class="text-gray-400">
                            Are you sure you want to delete this screening? This action cannot be undone.
                        </p>
                        <p class="text-sm text-red-400 mt-2">
                            Note: Screenings with sold tickets cannot be deleted.
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
                            wire:click="deleteScreening" 
                            class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors focus:outline-none"
                        >
                            Delete Screening
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
