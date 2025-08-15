<?php

namespace App\Livewire\Admin;

use App\Models\Film;
use App\Models\JadwalTayang;
use App\Models\Studio;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

class Screenings extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Filters
    public $search = '';
    public $dateFilter = '';
    public $studioFilter = '';
    public $filmFilter = '';
    public $viewMode = 'list'; // 'list', 'calendar', 'timeline'
    
    // Form properties
    public $screeningId;
    public $filmId;
    public $studioId;
    public $date;
    public $timeStart;
    public $timeEnd;
    public $price; // Tambahkan price property
    public $isFormVisible = false;
    public $isEditMode = false;
    public $confirmingDeletion = false;
    public $deletingId = null;
    
    // Calendar view properties
    public $currentDate;
    public $currentWeekStart;
    public $calendarDays = [];
    public $timeSlots = [];
    
    // Film duration properties
    public $selectedFilmDuration = 0;
    
    protected function rules()
    {
        return [
            'filmId' => 'required|exists:films,id',
            'studioId' => 'required|exists:studios,id',
            'date' => 'required|date|after_or_equal:today',
            'timeStart' => 'required|date_format:H:i',
            'price' => 'required|integer|min:0', // Tambahkan validasi untuk price
        ];
    }
    
    public function mount()
    {
        $this->currentDate = Carbon::today();
        $this->updateCalendarDays();
        $this->generateTimeSlots();
        $this->dateFilter = Carbon::today()->format('Y-m-d');
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingDateFilter()
    {
        $this->resetPage();
    }
    
    public function updatingStudioFilter()
    {
        $this->resetPage();
    }
    
    public function updatingFilmFilter()
    {
        $this->resetPage();
    }
    
    public function updatingViewMode()
    {
        if($this->viewMode === 'calendar') {
            $this->updateCalendarDays();
        }
    }
    
    public function updatedFilmId($value)
    {
        if ($value) {
            $film = Film::find($value);
            if ($film) {
                $this->selectedFilmDuration = $film->duration;
                $this->calculateEndTime();
            }
        } else {
            $this->selectedFilmDuration = 0;
            $this->timeEnd = null;
        }
    }
    
    public function updatedTimeStart($value)
    {
        $this->calculateEndTime();
    }
    
    public function updatedDate($value)
    {
        $this->calculatePrice();
    }
    
    public function calculateEndTime()
    {
        if ($this->timeStart && $this->selectedFilmDuration) {
            $startTime = Carbon::createFromFormat('H:i', $this->timeStart);
            $endTime = $startTime->copy()->addMinutes($this->selectedFilmDuration);
            $this->timeEnd = $endTime->format('H:i');
        }
    }
    
    public function calculatePrice()
    {
        if ($this->date) {
            $dateObj = Carbon::parse($this->date);
            // Cek apakah weekend (Sabtu atau Minggu)
            if ($dateObj->isWeekend()) {
                $this->price = 45000; // Harga weekend
            } else {
                $this->price = 30000; // Harga weekday
            }
        } else {
            $this->price = 30000; // Default price
        }
    }
    
    public function updateCalendarDays()
    {
        $this->currentWeekStart = $this->currentDate->copy()->startOfWeek();
        $this->calendarDays = [];
        
        for ($i = 0; $i < 7; $i++) {
            $day = $this->currentWeekStart->copy()->addDays($i);
            $this->calendarDays[] = [
                'date' => $day->format('Y-m-d'),
                'day' => $day->format('d'),
                'dayName' => $day->format('D'),
                'isToday' => $day->isToday(),
            ];
        }
    }
    
    public function previousWeek()
    {
        $this->currentDate = $this->currentDate->subWeek();
        $this->updateCalendarDays();
    }
    
    public function nextWeek()
    {
        $this->currentDate = $this->currentDate->addWeek();
        $this->updateCalendarDays();
    }
    
    public function generateTimeSlots()
    {
        $this->timeSlots = [];
        $startTime = Carbon::createFromTimeString('08:00');
        $endTime = Carbon::createFromTimeString('23:00');
        
        while ($startTime <= $endTime) {
            $this->timeSlots[] = $startTime->format('H:i');
            $startTime->addMinutes(30);
        }
    }
    
    public function getScreeningsForDay($date)
    {
        return JadwalTayang::with(['film', 'studio'])
            ->where('date', $date)
            ->when($this->studioFilter, function ($query) {
                return $query->where('studio_id', $this->studioFilter);
            })
            ->when($this->filmFilter, function ($query) {
                return $query->where('film_id', $this->filmFilter);
            })
            ->get();
    }
    
    public function calculatePosition($timeString)
    {
        // Convert time string to minutes since 8:00 AM
        $time = Carbon::createFromTimeString($timeString);
        $minutes = $time->diffInMinutes(Carbon::createFromTimeString('08:00'));
        
        // Each 30 minutes = 50px height
        return ($minutes / 30) * 50;
    }
    
    public function calculateHeight($start, $end)
    {
        $startTime = Carbon::createFromTimeString($start);
        $endTime = Carbon::createFromTimeString($end);
        $durationMinutes = $endTime->diffInMinutes($startTime);
        
        // Each 30 minutes = 50px height
        return max(50, ($durationMinutes / 30) * 50);
    }
    
    public function openForm($mode = 'create', $id = null)
    {
        $this->resetForm();
        $this->isFormVisible = true;
        $this->isEditMode = $mode === 'edit';
        
        if ($this->isEditMode && $id) {
            $screening = JadwalTayang::findOrFail($id);
            $this->screeningId = $screening->id;
            $this->filmId = $screening->film_id;
            $this->studioId = $screening->studio_id;
            $this->date = $screening->date->format('Y-m-d');
            $this->timeStart = $screening->time_start->format('H:i');
            $this->timeEnd = $screening->time_end->format('H:i');
            $this->price = $screening->price;
            
            // Get the film duration
            $film = Film::find($screening->film_id);
            if ($film) {
                $this->selectedFilmDuration = $film->duration;
            }
        } else {
            // Set defaults for creation
            $this->date = Carbon::today()->format('Y-m-d');
            $this->timeStart = '12:00';
            $this->calculatePrice(); // Set default price based on date
        }
    }
    
    public function closeForm()
    {
        $this->isFormVisible = false;
    }
    
    public function resetForm()
    {
        $this->reset([
            'screeningId', 'filmId', 'studioId', 'date', 'timeStart', 'timeEnd', 'selectedFilmDuration', 'price'
        ]);
        $this->resetValidation();
    }
    
    public function saveScreening()
    {
        $validatedData = $this->validate();
        
        // Calculate end time based on film duration
        if (!$this->timeEnd) {
            $this->calculateEndTime();
        }
        
        if (!$this->timeEnd) {
            $this->addError('filmId', 'Please select a film first.');
            return;
        }
        
        // Check for conflicts
        $timeStart = Carbon::parse($this->timeStart);
        $timeEnd = Carbon::parse($this->timeEnd);
        
        $conflictQuery = JadwalTayang::where('studio_id', $this->studioId)
            ->where('date', $this->date)
            ->where(function ($query) use ($timeStart, $timeEnd) {
                // Check if the new screening overlaps with any existing screening
                $query->where(function ($q) use ($timeStart, $timeEnd) {
                    $q->where('time_start', '<', $timeEnd->format('H:i'))
                      ->where('time_end', '>', $timeStart->format('H:i'));
                });
            });
        
        // Exclude current screening when editing
        if ($this->isEditMode) {
            $conflictQuery->where('id', '!=', $this->screeningId);
        }
        
        $conflict = $conflictQuery->first();
        
        if ($conflict) {
            $this->addError('timeStart', 'This time slot conflicts with another screening in this studio.');
            return;
        }
        
        if ($this->isEditMode) {
            $screening = JadwalTayang::findOrFail($this->screeningId);
            $message = 'Screening updated successfully';
        } else {
            $screening = new JadwalTayang();
            $message = 'Screening created successfully';
        }
        
        $screening->film_id = $this->filmId;
        $screening->studio_id = $this->studioId;
        $screening->date = $this->date;
        $screening->time_start = $this->timeStart;
        $screening->time_end = $this->timeEnd;
        $screening->price = $this->price; // Simpan harga
        $screening->save();
        
        $this->dispatch('showAlert', [
            'message' => $message,
            'type' => 'success'
        ]);
        
        $this->closeForm();
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deletingId = $id;
    }
    
    public function deleteScreening()
    {
        try {
            $screening = JadwalTayang::findOrFail($this->deletingId);
            
            // Check if there are any tickets sold for this screening
            $hasTickets = DB::table('tikets')
                ->where('jadwal_tayang_id', $this->deletingId)
                ->exists();
            
            if ($hasTickets) {
                $this->dispatch('showAlert', [
                    'message' => 'Cannot delete screening with sold tickets',
                    'type' => 'error'
                ]);
            } else {
                $screening->delete();
                $this->dispatch('showAlert', [
                    'message' => 'Screening deleted successfully',
                    'type' => 'success'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'message' => 'Error deleting screening: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
        
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }
    
    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }
    
    public function setToday()
    {
        $this->currentDate = Carbon::today();
        $this->updateCalendarDays();
    }
    
    public function render()
    {
        $studios = Studio::orderBy('name')->get();
        $films = Film::orderBy('title')->get();
        
        $screeningsQuery = JadwalTayang::with(['film', 'studio'])
            ->when($this->search, function ($query) {
                $query->whereHas('film', function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->dateFilter, function ($query) {
                $query->where('date', $this->dateFilter);
            })
            ->when($this->studioFilter, function ($query) {
                $query->where('studio_id', $this->studioFilter);
            })
            ->when($this->filmFilter, function ($query) {
                $query->where('film_id', $this->filmFilter);
            })
            ->orderBy('date')
            ->orderBy('time_start');
        
        $screenings = $screeningsQuery->paginate(10);
        
        // Group screenings by studio for timeline view
        $timelineScreenings = [];
        
        if ($this->viewMode === 'timeline' && $this->dateFilter) {
            $studiosWithScreenings = JadwalTayang::where('date', $this->dateFilter)
                ->when($this->studioFilter, function ($query) {
                    $query->where('studio_id', $this->studioFilter);
                })
                ->when($this->filmFilter, function ($query) {
                    $query->where('film_id', $this->filmFilter);
                })
                ->with(['studio', 'film'])
                ->get()
                ->groupBy('studio_id');
                
            foreach ($studios as $studio) {
                if (isset($studiosWithScreenings[$studio->id])) {
                    $timelineScreenings[$studio->id] = [
                        'studio' => $studio,
                        'screenings' => $studiosWithScreenings[$studio->id]
                    ];
                } else if (empty($this->studioFilter) || $this->studioFilter == $studio->id) {
                    $timelineScreenings[$studio->id] = [
                        'studio' => $studio,
                        'screenings' => []
                    ];
                }
            }
        }
        
        return view('livewire.admin.screenings', [
            'screenings' => $screenings,
            'studios' => $studios,
            'films' => $films,
            'timelineScreenings' => $timelineScreenings,
        ]);
    }
}
