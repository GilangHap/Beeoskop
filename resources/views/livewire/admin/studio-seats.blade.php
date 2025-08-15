<div class="py-4">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1">
                <div class="flex items-center">
                    <a href="{{ route('admin.studio') }}" wire:navigate class="mr-3 text-gray-400 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Studio {{ $studio->name }} - Seat Management</h1>
                        <p class="mt-1 text-sm text-gray-400">Configure and manage seating arrangement</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex flex-wrap gap-2 items-center justify-end">
                    <button 
                        wire:click="toggleEditMode" 
                        class="{{ $editMode ? 'bg-primary text-black' : 'bg-gray-800 border border-gray-700 text-white' }} px-4 py-2 rounded-lg font-medium flex items-center transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        {{ $editMode ? 'Exit Edit Mode' : 'Edit Seats' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Panel -->
    <div class="bg-dark border border-gray-800 rounded-xl p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gray-800/50 p-4 rounded-lg">
                <div class="text-sm text-gray-400">Studio</div>
                <div class="font-bold text-lg text-white">{{ $studio->name }}</div>
            </div>
            <div class="bg-gray-800/50 p-4 rounded-lg">
                <div class="text-sm text-gray-400">Capacity</div>
                <div class="font-bold text-lg text-white">{{ $capacity }} seats</div>
            </div>
            <div class="bg-gray-800/50 p-4 rounded-lg">
                <div class="text-sm text-gray-400">Configured Seats</div>
                <div class="font-bold text-lg text-white">{{ $totalSeats }} <span class="text-sm text-gray-400 font-normal">({{ $totalSeats > 0 ? round(($totalSeats / $capacity) * 100) : 0 }}%)</span></div>
            </div>
            <div class="bg-gray-800/50 p-4 rounded-lg">
                <div class="text-sm text-gray-400">Remaining</div>
                <div class="font-bold text-lg {{ $remainingSeats > 0 ? 'text-yellow-400' : 'text-green-400' }}">
                    {{ $remainingSeats }} seats
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seat Configuration Tools -->
    <div class="bg-dark border border-gray-800 rounded-xl overflow-hidden mb-6">
        <div class="flex flex-wrap items-center justify-between p-4 border-b border-gray-800">
            <h3 class="text-lg font-medium text-white">Seating Layout</h3>
            
            <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                <button 
                    wire:click="toggleChairLettering" 
                    class="px-3 py-1.5 bg-gray-800 border border-gray-700 text-gray-300 rounded hover:bg-gray-700 transition-colors text-sm"
                >
                    {{ $chairLettering ? 'Use Number Rows' : 'Use Letter Rows' }}
                </button>
                
                <div class="flex items-center border border-gray-700 rounded overflow-hidden">
                    <button 
                        wire:click="removeRow" 
                        class="bg-gray-800 text-gray-300 p-1.5 hover:bg-red-900/20 hover:text-red-400 transition-colors"
                        title="Remove Row"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <span class="px-3 bg-gray-800/50 text-gray-400">{{ $rows }} rows</span>
                    <button 
                        wire:click="addRow" 
                        class="bg-gray-800 text-gray-300 p-1.5 hover:bg-green-900/20 hover:text-green-400 transition-colors"
                        title="Add Row"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                
                <div class="flex items-center border border-gray-700 rounded overflow-hidden">
                    <button 
                        wire:click="removeColumn" 
                        class="bg-gray-800 text-gray-300 p-1.5 hover:bg-red-900/20 hover:text-red-400 transition-colors"
                        title="Remove Column"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <span class="px-3 bg-gray-800/50 text-gray-400">{{ $columns }} columns</span>
                    <button 
                        wire:click="addColumn" 
                        class="bg-gray-800 text-gray-300 p-1.5 hover:bg-green-900/20 hover:text-green-400 transition-colors"
                        title="Add Column"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Edit mode controls -->
        @if($editMode)
            <div class="bg-primary/10 border-b border-primary/20 p-4">
                <div class="flex flex-col space-y-3 md:space-y-0 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-primary mr-3">Edit Mode</span>
                        <span class="text-sm text-gray-300">{{ count($selectedSeats) }} seats selected</span>
                    </div>
                    
                    <!-- Selection Tools -->
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="inline-block relative">
                            <button 
                                type="button"
                                x-data="{}"
                                x-on:click.prevent="$refs.selectionDropdown.classList.toggle('hidden')"
                                class="px-3 py-1.5 bg-primary/20 border border-primary/20 text-primary rounded hover:bg-primary/30 transition-colors text-sm flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                </svg>
                                Selection Tools
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div 
                                x-ref="selectionDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-dark border border-gray-700 rounded-md shadow-lg z-10"
                            >
                                <div class="py-1">
                                    <button 
                                        type="button"
                                        wire:click="selectAllEmptySeats" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Select All Empty Spaces
                                    </button>
                                    <button 
                                        type="button"
                                        wire:click="selectAllConfiguredSeats" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Select All Configured Seats
                                    </button>
                                    <button 
                                        type="button"
                                        wire:click="selectAllSeats" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Select All Seats
                                    </button>
                                    <div class="border-t border-gray-700 my-1"></div>
                                    <button 
                                        type="button"
                                        wire:click="clearSelection" 
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <button 
                            wire:click="openBulkModal('create')" 
                            class="px-3 py-1.5 bg-green-800/20 border border-green-900 text-green-400 rounded hover:bg-green-800/40 transition-colors text-sm flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Bulk Create
                        </button>
                        
                        <button 
                            wire:click="openBulkModal('delete')" 
                            class="px-3 py-1.5 bg-red-800/20 border border-red-900 text-red-400 rounded hover:bg-red-800/40 transition-colors text-sm flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Bulk Delete
                        </button>
                    </div>
                    
                    <!-- Action Buttons for Selected Seats -->
                    @if(count($selectedSeats) > 0)
                        <div class="flex flex-wrap items-center gap-2">
                            <button 
                                wire:click="createSelectedSeats" 
                                class="px-3 py-1.5 bg-primary text-black font-medium rounded hover:bg-amber-400 transition-colors text-sm"
                            >
                                Create Selected ({{ count($selectedSeats) }})
                            </button>
                            <button 
                                wire:click="deleteSelectedSeats" 
                                class="px-3 py-1.5 bg-red-600 text-white font-medium rounded hover:bg-red-700 transition-colors text-sm"
                            >
                                Delete Selected ({{ count($selectedSeats) }})
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Seating Grid -->
        <div class="p-4 overflow-auto">
            <!-- Screen -->
            <div class="flex justify-center mb-8">
                <div class="w-3/4 max-w-2xl">
                    <div class="text-center text-xs text-gray-400 mb-1">SCREEN</div>
                    <div class="h-5 bg-gray-700 rounded-t-xl w-full shadow-lg"></div>
                </div>
            </div>
            
            <div class="flex justify-center">
                <div class="relative">
                    <!-- Seat Labels - Columns (top) -->
                    <div class="flex mb-1 ml-8">
                        @for ($col = 1; $col <= $columns; $col++)
                            <div class="w-12 h-6 flex items-center justify-center text-gray-400 text-xs">
                                {{ $col }}
                            </div>
                        @endfor
                    </div>
                    
                    <!-- Seat Grid -->
                    <div class="flex flex-col">
                        @for ($row = 1; $row <= $rows; $row++)
                            <div class="flex items-center mb-2">
                                <!-- Row Label -->
                                <div class="w-8 h-12 flex items-center justify-center text-gray-400 font-medium">
                                    {{ $chairLettering ? chr(64 + $row) : $row }}
                                </div>
                                
                                <!-- Seats in this row -->
                                @for ($col = 1; $col <= $columns; $col++)
                                    <div class="w-12 h-12 p-1">
                                        @php
                                            $isSeatTaken = !empty($seats[$row][$col]);
                                            $isSelected = in_array("$row-$col", $selectedSeats);
                                            $seatLabel = isset($chairLabels[$row][$col]) ? $chairLabels[$row][$col] : '';
                                        @endphp
                                        
                                        @if($editMode)
                                            <button 
                                                wire:click="toggleSeatSelection({{ $row }}, {{ $col }})" 
                                                class="{{ $isSeatTaken ? 'bg-primary text-black' : 'bg-gray-800 text-gray-300' }} 
                                                       {{ $isSelected ? 'ring-2 ring-white' : '' }}
                                                       w-full h-full rounded flex items-center justify-center text-xs font-medium hover:opacity-80 transition-all"
                                                title="{{ $isSeatTaken ? 'Seat ' . $seatLabel . ' (Click to select)' : 'Empty space (Click to select)' }}"
                                            >
                                                {{ $isSeatTaken ? $seatLabel : '' }}
                                            </button>
                                        @else
                                            @if($isSeatTaken)
                                                <div class="bg-primary text-black w-full h-full rounded flex items-center justify-center text-xs font-medium" title="Seat {{ $seatLabel }}">
                                                    {{ $seatLabel }}
                                                </div>
                                            @else
                                                <div class="bg-gray-800/50 border border-dashed border-gray-700 w-full h-full rounded"></div>
                                            @endif
                                        @endif
                                    </div>
                                @endfor
                                
                                <!-- Row Label (right side) -->
                                <div class="w-8 h-12 flex items-center justify-center text-gray-400 font-medium">
                                    {{ $chairLettering ? chr(64 + $row) : $row }}
                                </div>
                            </div>
                        @endfor
                    </div>
                    
                    <!-- Seat Labels - Columns (bottom) -->
                    <div class="flex mt-1 ml-8">
                        @for ($col = 1; $col <= $columns; $col++)
                            <div class="w-12 h-6 flex items-center justify-center text-gray-400 text-xs">
                                {{ $col }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-gray-800/50 p-4 border-t border-gray-800">
            <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-400">
                <div class="flex items-center mb-2 md:mb-0">
                    <span class="flex items-center mr-4">
                        <span class="inline-block w-3 h-3 bg-primary rounded mr-1"></span>
                        Configured Seat
                    </span>
                    <span class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-gray-800 border border-dashed border-gray-700 rounded mr-1"></span>
                        Empty Space
                    </span>
                </div>
                
                <div>
                    @if($totalSeats < $capacity)
                        <span class="text-yellow-400">Warning: </span>
                        <span>{{ $capacity - $totalSeats }} seats still need to be configured</span>
                    @else
                        <span class="text-green-400">All {{ $capacity }} seats configured</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bulk Action Modal -->
    <div x-data="{ show: @entangle('showBulkModal') }" x-cloak x-show="show" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            
            <!-- Background overlay -->
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
            ></div>

            <!-- Modal panel -->
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
                            {{ $bulkAction === 'create' ? 'Bulk Create Seats' : 'Bulk Delete Seats' }}
                        </h3>
                        <button wire:click="$set('showBulkModal', false)" class="text-gray-400 hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="text-sm text-gray-400 mb-4">
                        Select a range of rows and columns to {{ $bulkAction === 'create' ? 'create' : 'delete' }} seats in bulk.
                    </div>
                    
                    <form wire:submit.prevent="processBulkAction">
                        <div class="space-y-4">
                            <!-- Row Range -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="selectedRowStart" class="block text-sm font-medium text-gray-300 mb-1">
                                        Start Row
                                    </label>
                                    <input 
                                        type="text" 
                                        id="selectedRowStart" 
                                        wire:model.blur="selectedRowStart" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                        placeholder="A"
                                        maxlength="1"
                                    >
                                </div>
                                <div>
                                    <label for="selectedRowEnd" class="block text-sm font-medium text-gray-300 mb-1">
                                        End Row
                                    </label>
                                    <input 
                                        type="text" 
                                        id="selectedRowEnd" 
                                        wire:model.blur="selectedRowEnd" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                        placeholder="D"
                                        maxlength="1"
                                    >
                                </div>
                            </div>
                            
                            <!-- Column Range -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="selectedColStart" class="block text-sm font-medium text-gray-300 mb-1">
                                        Start Column
                                    </label>
                                    <input 
                                        type="number" 
                                        id="selectedColStart" 
                                        wire:model.blur="selectedColStart" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                        placeholder="1"
                                        min="1"
                                    >
                                </div>
                                <div>
                                    <label for="selectedColEnd" class="block text-sm font-medium text-gray-300 mb-1">
                                        End Column
                                    </label>
                                    <input 
                                        type="number" 
                                        id="selectedColEnd" 
                                        wire:model.blur="selectedColEnd" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2 px-4 text-white focus:outline-none focus:border-primary"
                                        placeholder="8"
                                        min="1"
                                    >
                                </div>
                            </div>
                            
                            <!-- Range Preview -->
                            <div class="bg-gray-800/50 rounded-lg p-3 border border-gray-800">
                                <div class="text-sm text-gray-300 mb-1">
                                    Selected Range: <span class="font-mono">{{ $selectedRowStart }}{{ $selectedColStart }}</span> to <span class="font-mono">{{ $selectedRowEnd }}{{ $selectedColEnd }}</span>
                                </div>
                                <div class="text-xs text-gray-400">
                                    @php
                                        $rowStart = ord(strtoupper($selectedRowStart)) - 64;
                                        $rowEnd = ord(strtoupper($selectedRowEnd)) - 64;
                                        if ($rowStart > 0 && $rowEnd > 0 && $selectedColStart > 0 && $selectedColEnd > 0) {
                                            $rowCount = abs($rowEnd - $rowStart) + 1;
                                            $colCount = abs($selectedColEnd - $selectedColStart) + 1;
                                            $totalSeatsInRange = $rowCount * $colCount;
                                            echo "This will affect approximately $totalSeatsInRange seats.";
                                        } else {
                                            echo "Please enter valid row and column values.";
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button 
                                type="button"
                                wire:click="$set('showBulkModal', false)" 
                                class="px-4 py-2 bg-gray-800 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition-colors focus:outline-none"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="px-4 py-2 {{ $bulkAction === 'create' ? 'bg-primary text-black' : 'bg-red-600 text-white' }} font-medium rounded-lg hover:{{ $bulkAction === 'create' ? 'bg-amber-400' : 'bg-red-700' }} transition-colors focus:outline-none"
                            >
                                {{ $bulkAction === 'create' ? 'Create Seats' : 'Delete Seats' }}
                            </button>
                        </div>
                    </form>
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
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('click', function(event) {
            // Close dropdown when clicking outside
            const dropdowns = document.querySelectorAll('[x-ref="selectionDropdown"]');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target) && 
                    !event.target.closest('button[x-on\\:click\\.prevent]')) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
</div>
