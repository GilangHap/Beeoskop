<div>
    <!-- Header Section -->
    <section class="mb-8">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-wrap items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">Select Your Seats</h1>
                    <p class="text-gray-400">Choose your preferred seats for the movie</p>
                </div>
                
                <div class="flex items-center">
                    <a href="{{ route('movie.detail', $film->id) }}" wire:navigate class="text-gray-400 hover:text-primary flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Movie
                    </a>
                </div>
            </div>
            
            <div class="bg-dark rounded-xl p-4 sm:p-6 border border-gray-800">
                <div class="flex flex-wrap gap-4">
                    <img 
                        src="{{ $film->poster_url }}" 
                        alt="{{ $film->title }}" 
                        class="w-16 h-24 rounded object-cover"
                        onerror="this.src='https://placehold.co/128x192/1A1A1A/FFCC00.png?text=BEEOSKOP'"
                    >
                    <div>
                        <h2 class="text-xl font-bold text-white mb-1">{{ $film->title }}</h2>
                        <div class="flex flex-wrap gap-4 text-sm">
                            <div>
                                <span class="text-gray-400">Date:</span>
                                <span class="text-white ml-1">{{ $showDate }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Time:</span>
                                <span class="text-white ml-1">{{ $showTime }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Studio:</span>
                                <span class="text-white ml-1">{{ $studio->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Price:</span>
                                <span class="text-green-400 ml-1">Rp {{ number_format($ticketPrice, 0, ',', '.') }}</span>
                                @if(Carbon\Carbon::parse($jadwal->date)->isWeekend())
                                    <span class="ml-1 text-xs px-2 py-0.5 bg-blue-900/30 text-blue-300 rounded-full">Weekend</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <section class="mb-12">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Seat Selection Area -->
                <div class="lg:col-span-2">
                    <div class="bg-dark rounded-xl p-6 border border-gray-800">
                        <!-- Screen Area -->
                        <div class="mb-8 relative">
                            <div class="w-full h-2 bg-primary rounded-full mb-2"></div>
                            <div class="w-3/4 h-10 mx-auto bg-gray-800 rounded-t-3xl flex items-center justify-center border-t border-x border-gray-700">
                                <span class="text-gray-400 text-sm">Screen</span>
                            </div>
                            <div class="absolute h-28 inset-x-8 -top-4 bg-primary/5 rounded-[50%/100%] blur-md -z-10"></div>
                        </div>
                        
                        <!-- Seat Legend -->
                        <div class="flex flex-wrap gap-4 justify-center mb-8">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-gray-700"></div>
                                <span class="text-sm text-gray-400">Available</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-primary"></div>
                                <span class="text-sm text-gray-400">Selected</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-red-500/40"></div>
                                <span class="text-sm text-gray-400">Booked</span>
                            </div>
                        </div>
                        
                        <!-- Seat Map -->
                        <div class="overflow-x-auto">
                            <div class="min-w-[500px] flex flex-col items-center gap-3 pb-4">
                                @if(count($studioSeats) > 0)
                                    @foreach($uniqueRows as $row)
                                        <div class="flex gap-2 items-center w-full">
                                            <!-- Label baris menggunakan abjad -->
                                            <div class="w-6 text-center text-gray-400 font-medium">{{ $row }}</div>
                                            
                                            <div class="flex flex-1 justify-center gap-2">
                                                @for($col = 1; $col <= $maxColumn; $col++)
                                                    @php
                                                        $seatExists = false;
                                                        $seatNumber = "";
                                                        
                                                        // Check if this seat exists in the current row
                                                        if (isset($studioSeats[$row])) {
                                                            $currentSeat = collect($studioSeats[$row])->firstWhere('coloumn', $col);
                                                            if ($currentSeat) {
                                                                $seatExists = true;
                                                                $seatNumber = $currentSeat['chair_number'];
                                                            }
                                                        }
                                                        
                                                        if ($seatExists) {
                                                            $isBooked = in_array($seatNumber, $bookedSeats);
                                                            $isSelected = in_array($seatNumber, $selectedSeats);
                                                        }
                                                    @endphp
                                                    
                                                    @if($seatExists)
                                                        <button 
                                                            wire:click="toggleSeat('{{ $seatNumber }}')"
                                                            class="w-8 h-8 rounded flex items-center justify-center text-xs font-medium {{ $isBooked ? 'bg-red-500/40 text-white/50 cursor-not-allowed' : ($isSelected ? 'bg-primary text-black' : 'bg-gray-700 text-white hover:bg-gray-600') }}"
                                                            {{ $isBooked ? 'disabled' : '' }}
                                                            title="Seat {{ $seatNumber }}"
                                                        >
                                                            <!-- Tampilkan hanya nomor kolom -->
                                                            {{ $col }}
                                                        </button>
                                                    @else
                                                        <!-- Spasi untuk kursi yang tidak ada -->
                                                        <div class="w-8"></div>
                                                    @endif
                                                    
                                                    <!-- Add gap after the 4th seat for aisle -->
                                                    @if($col == 4 && $maxColumn > 8)
                                                        <div class="w-4"></div>
                                                    @endif
                                                @endfor
                                            </div>
                                            
                                            <!-- Label baris menggunakan abjad di sisi kanan -->
                                            <div class="w-6 text-center text-gray-400 font-medium">{{ $row }}</div>
                                        </div>
                                        
                                        <!-- Add gap after certain rows -->
                                        @if(in_array($row, ['B', 'E']))
                                            <div class="h-4"></div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-center p-4 text-gray-400">
                                        No seat layout available for this studio
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-dark rounded-xl border border-gray-800 sticky top-24">
                        <div class="p-6 border-b border-gray-800">
                            <h3 class="text-lg font-bold text-white mb-6">Order Summary</h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-400">Selected Seats</span>
                                    <div class="text-right">
                                        @if(count($selectedSeats) > 0)
                                            <div class="text-white font-medium">{{ implode(', ', $selectedSeats) }}</div>
                                            <div class="text-sm text-gray-500">{{ count($selectedSeats) }} seat(s)</div>
                                        @else
                                            <span class="text-gray-500">No seats selected</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Ticket Price</span>
                                    <span class="text-white font-medium">Rp {{ number_format($ticketPrice, 0, ',', '.') }} x {{ count($selectedSeats) }}</span>
                                </div>
                                
                                <div class="pt-4 border-t border-gray-800">
                                    <div class="flex justify-between">
                                        <span class="font-bold text-white">Total</span>
                                        <span class="font-bold text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <button 
                                wire:click="proceedToCheckout"
                                class="w-full py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-lg transition flex items-center justify-center gap-2 {{ count($selectedSeats) == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ count($selectedSeats) == 0 ? 'disabled' : '' }}
                            >
                                Continue to Payment
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Additional Info -->
                        <div class="p-6">
                            <h4 class="font-medium text-gray-300 mb-2">Important Information:</h4>
                            <ul class="text-sm text-gray-400 space-y-2">
                                <li class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    You can select up to 6 seats per transaction
                                </li>
                                <li class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Selected seats are reserved for 10 minutes during payment
                                </li>
                                <li class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Tickets cannot be refunded or exchanged
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>