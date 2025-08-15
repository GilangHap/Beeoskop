<?php

namespace App\Livewire\Admin;

use App\Models\Kursi;
use App\Models\Studio;
use Livewire\Component;
use Livewire\Attributes\Layout;

class StudioSeats extends Component
{
    #[Layout('livewire.components.layouts.admin')]
    
    public $studioId;
    public $studio;
    public $rows = 5;
    public $columns = 8;
    public $seats = [];
    public $chairLabels = [];
    public $selectedSeats = [];
    public $editMode = false;
    public $chairLettering = true; // Use letters (A, B, C) instead of numbers for rows
    
    // Modal properties
    public $showBulkModal = false;
    public $bulkAction = 'create'; // create or delete
    public $selectedRowStart = 'A';
    public $selectedRowEnd = 'A';
    public $selectedColStart = 1;
    public $selectedColEnd = 8;

    public function mount($id)
    {
        $this->studioId = $id;
        $this->studio = Studio::with('kursis')->findOrFail($id);
        $this->loadSeats();
    }
    
    public function loadSeats()
    {
        // Initialize seats array as empty
        $this->seats = [];
        
        // Find the max number of rows and columns from existing seats
        $existingSeats = $this->studio->kursis;
        
        if ($existingSeats->count() > 0) {
            // If we have existing seats, calculate the grid size
            $maxRow = $existingSeats->max('line');
            $maxCol = $existingSeats->max('coloumn');
            
            $this->rows = max($this->rows, $maxRow);
            $this->columns = max($this->columns, $maxCol);
        }
        
        // Create a 2D array for seats
        for ($i = 1; $i <= $this->rows; $i++) {
            for ($j = 1; $j <= $this->columns; $j++) {
                $this->seats[$i][$j] = null;
            }
        }
        
        // Fill in existing seats
        foreach ($existingSeats as $seat) {
            $this->seats[$seat->line][$seat->coloumn] = [
                'id' => $seat->id,
                'chair_number' => $seat->chair_number,
                'line' => $seat->line,
                'coloumn' => $seat->coloumn
            ];
        }
        
        // Generate chair labels (A1, A2, B1, B2, etc.)
        $this->generateChairLabels();
    }
    
    public function generateChairLabels()
    {
        $this->chairLabels = [];
        
        for ($i = 1; $i <= $this->rows; $i++) {
            for ($j = 1; $j <= $this->columns; $j++) {
                if ($this->chairLettering) {
                    $rowLabel = chr(64 + $i); // Convert to A, B, C, etc.
                } else {
                    $rowLabel = $i;
                }
                
                $this->chairLabels[$i][$j] = $rowLabel . $j;
            }
        }
    }
    
    public function toggleSeatSelection($row, $col)
    {
        $key = "$row-$col";
        
        if (in_array($key, $this->selectedSeats)) {
            // Remove from selection
            $this->selectedSeats = array_diff($this->selectedSeats, [$key]);
        } else {
            // Add to selection
            $this->selectedSeats[] = $key;
        }
    }
    
    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
        $this->selectedSeats = [];
    }
    
    public function createSeat($row, $col)
    {
        // Don't create if seat already exists
        if (!empty($this->seats[$row][$col])) {
            return;
        }
        
        // Calculate chair number
        $chairNumber = $this->chairLabels[$row][$col];
        
        // Create new seat
        $seat = Kursi::create([
            'studio_id' => $this->studioId,
            'chair_number' => $chairNumber,
            'line' => $row,
            'coloumn' => $col, // Note the column spelling in your model
        ]);
        
        // Update local data
        $this->seats[$row][$col] = [
            'id' => $seat->id,
            'chair_number' => $chairNumber,
            'line' => $row,
            'coloumn' => $col
        ];
        
        // Remove from selection if in edit mode
        if ($this->editMode) {
            $key = "$row-$col";
            $this->selectedSeats = array_diff($this->selectedSeats, [$key]);
        }
        
        $this->dispatch('showAlert', [
            'message' => "Seat $chairNumber created successfully",
            'type' => 'success'
        ]);
    }
    
    public function deleteSeat($row, $col)
    {
        // Check if seat exists
        if (empty($this->seats[$row][$col])) {
            return;
        }
        
        $seatId = $this->seats[$row][$col]['id'];
        $chairNumber = $this->seats[$row][$col]['chair_number'];
        
        // Delete the seat
        Kursi::destroy($seatId);
        
        // Update local data
        $this->seats[$row][$col] = null;
        
        // Remove from selection if in edit mode
        if ($this->editMode) {
            $key = "$row-$col";
            $this->selectedSeats = array_diff($this->selectedSeats, [$key]);
        }
        
        $this->dispatch('showAlert', [
            'message' => "Seat $chairNumber deleted successfully",
            'type' => 'success'
        ]);
    }
    
    public function addRow()
    {
        $this->rows++;
        
        // Add new empty row
        for ($j = 1; $j <= $this->columns; $j++) {
            $this->seats[$this->rows][$j] = null;
        }
        
        // Update chair labels
        $this->generateChairLabels();
    }
    
    public function removeRow()
    {
        // Check if we have more than 1 row
        if ($this->rows <= 1) {
            return;
        }
        
        // Check if the last row has any seats
        $lastRowHasSeats = false;
        for ($j = 1; $j <= $this->columns; $j++) {
            if (!empty($this->seats[$this->rows][$j])) {
                $lastRowHasSeats = true;
                break;
            }
        }
        
        if ($lastRowHasSeats) {
            $this->dispatch('showAlert', [
                'message' => 'Cannot remove row that has seats. Delete seats first.',
                'type' => 'error'
            ]);
            return;
        }
        
        // Remove the last row
        unset($this->seats[$this->rows]);
        $this->rows--;
        
        // Update chair labels
        $this->generateChairLabels();
    }
    
    public function addColumn()
    {
        $this->columns++;
        
        // Add new empty column
        for ($i = 1; $i <= $this->rows; $i++) {
            $this->seats[$i][$this->columns] = null;
        }
        
        // Update chair labels
        $this->generateChairLabels();
    }
    
    public function removeColumn()
    {
        // Check if we have more than 1 column
        if ($this->columns <= 1) {
            return;
        }
        
        // Check if the last column has any seats
        $lastColHasSeats = false;
        for ($i = 1; $i <= $this->rows; $i++) {
            if (!empty($this->seats[$i][$this->columns])) {
                $lastColHasSeats = true;
                break;
            }
        }
        
        if ($lastColHasSeats) {
            $this->dispatch('showAlert', [
                'message' => 'Cannot remove column that has seats. Delete seats first.',
                'type' => 'error'
            ]);
            return;
        }
        
        // Remove the last column
        for ($i = 1; $i <= $this->rows; $i++) {
            unset($this->seats[$i][$this->columns]);
        }
        $this->columns--;
        
        // Update chair labels
        $this->generateChairLabels();
    }
    
    public function toggleChairLettering()
    {
        $this->chairLettering = !$this->chairLettering;
        $this->generateChairLabels();
        
        // We need to update existing chair numbers
        $existingSeats = $this->studio->kursis;
        
        foreach ($existingSeats as $seat) {
            $row = $seat->line;
            $col = $seat->coloumn;
            
            if ($this->chairLettering) {
                $chairNumber = chr(64 + $row) . $col;
            } else {
                $chairNumber = $row . '-' . $col;
            }
            
            // Update the chair number
            $seat->chair_number = $chairNumber;
            $seat->save();
            
            // Update local data
            if (isset($this->seats[$row][$col])) {
                $this->seats[$row][$col]['chair_number'] = $chairNumber;
            }
        }
    }
    
    public function createSelectedSeats()
    {
        foreach ($this->selectedSeats as $key) {
            list($row, $col) = explode('-', $key);
            $this->createSeat($row, $col);
        }
        
        $this->selectedSeats = [];
    }
    
    public function deleteSelectedSeats()
    {
        foreach ($this->selectedSeats as $key) {
            list($row, $col) = explode('-', $key);
            $this->deleteSeat($row, $col);
        }
        
        $this->selectedSeats = [];
    }
    
    public function openBulkModal($action)
    {
        $this->bulkAction = $action;
        $this->showBulkModal = true;
        
        // Set default values
        $this->selectedRowStart = 'A';
        $this->selectedRowEnd = chr(64 + min($this->rows, 5));
        $this->selectedColStart = 1;
        $this->selectedColEnd = min($this->columns, 8);
    }
    
    public function processBulkAction()
    {
        // Convert letter rows to numbers
        $rowStart = ord(strtoupper($this->selectedRowStart)) - 64;
        $rowEnd = ord(strtoupper($this->selectedRowEnd)) - 64;
        
        // Validate input
        if ($rowStart < 1 || $rowStart > $this->rows || $rowEnd < 1 || $rowEnd > $this->rows) {
            $this->dispatch('showAlert', [
                'message' => 'Invalid row selection',
                'type' => 'error'
            ]);
            return;
        }
        
        if ($this->selectedColStart < 1 || $this->selectedColStart > $this->columns || 
            $this->selectedColEnd < 1 || $this->selectedColEnd > $this->columns) {
            $this->dispatch('showAlert', [
                'message' => 'Invalid column selection',
                'type' => 'error'
            ]);
            return;
        }
        
        // Make sure start values are smaller than end values
        if ($rowStart > $rowEnd) {
            list($rowStart, $rowEnd) = [$rowEnd, $rowStart];
        }
        
        if ($this->selectedColStart > $this->selectedColEnd) {
            list($this->selectedColStart, $this->selectedColEnd) = [$this->selectedColEnd, $this->selectedColStart];
        }
        
        // Process seats in the selected range
        $count = 0;
        for ($i = $rowStart; $i <= $rowEnd; $i++) {
            for ($j = $this->selectedColStart; $j <= $this->selectedColEnd; $j++) {
                if ($this->bulkAction === 'create' && empty($this->seats[$i][$j])) {
                    $this->createSeat($i, $j);
                    $count++;
                } elseif ($this->bulkAction === 'delete' && !empty($this->seats[$i][$j])) {
                    $this->deleteSeat($i, $j);
                    $count++;
                }
            }
        }
        
        $actionText = $this->bulkAction === 'create' ? 'created' : 'deleted';
        $this->dispatch('showAlert', [
            'message' => "$count seats $actionText successfully",
            'type' => 'success'
        ]);
        
        $this->showBulkModal = false;
    }
    
    public function selectAllEmptySeats()
    {
        // Clear current selection
        $this->selectedSeats = [];
        
        // Select all empty seats
        for ($i = 1; $i <= $this->rows; $i++) {
            for ($j = 1; $j <= $this->columns; $j++) {
                if (empty($this->seats[$i][$j])) {
                    $this->selectedSeats[] = "$i-$j";
                }
            }
        }
        
        $this->dispatch('showAlert', [
            'message' => count($this->selectedSeats) . ' empty seats selected',
            'type' => 'success'
        ]);
    }
    
    public function selectAllConfiguredSeats()
    {
        // Clear current selection
        $this->selectedSeats = [];
        
        // Select all configured seats
        for ($i = 1; $i <= $this->rows; $i++) {
            for ($j = 1; $j <= $this->columns; $j++) {
                if (!empty($this->seats[$i][$j])) {
                    $this->selectedSeats[] = "$i-$j";
                }
            }
        }
        
        $this->dispatch('showAlert', [
            'message' => count($this->selectedSeats) . ' configured seats selected',
            'type' => 'success'
        ]);
    }
    
    public function selectAllSeats()
    {
        // Clear current selection
        $this->selectedSeats = [];
        
        // Select all seats
        for ($i = 1; $i <= $this->rows; $i++) {
            for ($j = 1; $j <= $this->columns; $j++) {
                $this->selectedSeats[] = "$i-$j";
            }
        }
        
        $this->dispatch('showAlert', [
            'message' => count($this->selectedSeats) . ' seats selected',
            'type' => 'success'
        ]);
    }
    
    public function clearSelection()
    {
        $previousCount = count($this->selectedSeats);
        $this->selectedSeats = [];
        
        $this->dispatch('showAlert', [
            'message' => 'Selection cleared (' . $previousCount . ' seats)',
            'type' => 'success'
        ]);
    }
    
    public function render()
    {
        return view('livewire.admin.studio-seats', [
            'totalSeats' => $this->studio->kursis->count(),
            'capacity' => $this->studio->capacity,
            'remainingSeats' => $this->studio->capacity - $this->studio->kursis->count(),
        ]);
    }
}
