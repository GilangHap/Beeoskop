<?php

namespace App\Livewire\User;

use App\Models\Film;
use App\Models\JadwalTayang;
use App\Models\Studio;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

class DetailFilm extends Component
{
    #[Layout('livewire.components.layouts.app')]
    
    public $filmId;
    public $film;
    public $selectedDate;
    public $availableDates = [];
    public $showtimes = [];
    public $studioShowtimes = [];
    public $trailerOpen = false;
    public $isWeekend = false; // Tambahkan property untuk deteksi weekend

    public function mount($id)
    {
        $this->filmId = $id;
        $this->film = Film::with('genre')->findOrFail($id);
        
        // Get all available dates for this film using select distinct
        $jadwalDates = DB::table('jadwal_tayangs')
            ->where('film_id', $this->filmId)
            ->where('date', '>=', Carbon::today()->format('Y-m-d'))
            ->select('date')
            ->distinct()
            ->orderBy('date')
            ->pluck('date');
        
        // Format dates for display
        foreach ($jadwalDates as $date) {
            $this->availableDates[] = Carbon::parse($date);
        }
        
        // Set default selected date to the first available date or today
        if (count($this->availableDates) > 0) {
            $this->selectedDate = $this->availableDates[0]->format('Y-m-d');
            // Cek apakah tanggal yang dipilih adalah weekend
            $this->isWeekend = Carbon::parse($this->selectedDate)->isWeekend();
        } else {
            $this->selectedDate = Carbon::today()->format('Y-m-d');
            $this->isWeekend = Carbon::today()->isWeekend();
        }
        
        // Load showtimes for the selected date
        $this->loadShowtimes();
    }
    
    public function updatedSelectedDate()
    {
        // Update weekend flag when date changes
        $this->isWeekend = Carbon::parse($this->selectedDate)->isWeekend();
        $this->loadShowtimes();
    }
    
    // Tambahkan method untuk memeriksa apakah jadwal untuk tanggal berikutnya
    // yang waktunya belum datang harus tetap bisa diakses
    private function checkFutureDate($jadwal)
    {
        $today = Carbon::today();
        $showDate = Carbon::parse($jadwal->date);
        
        // Jika tanggal jadwal > hari ini, maka jadwal belum expired
        if ($showDate->greaterThan($today)) {
            return false; // Tidak expired
        }
        
        // Jika tanggal jadwal = hari ini, periksa waktunya
        if ($showDate->isSameDay($today)) {
            $showDateTime = Carbon::parse($jadwal->date)->setTimeFromTimeString($jadwal->time_start);
            return now() > $showDateTime; // Expired jika waktu sekarang > waktu jadwal
        }
        
        // Jika tanggal jadwal < hari ini, maka jadwal sudah expired
        return true; // Expired
    }

    public function loadShowtimes()
    {
        // Get all showtimes for this film and date
        $this->showtimes = JadwalTayang::where('film_id', $this->filmId)
            ->where('date', $this->selectedDate)
            ->orderBy('time_start')
            ->get()
            ->map(function($jadwal) {
                // Gunakan method khusus untuk memeriksa jadwal expired
                $jadwal->is_expired = $this->checkFutureDate($jadwal);
                return $jadwal;
            });
            
        // Get all studios that have showtimes for this film and date
        $studioIds = $this->showtimes->pluck('studio_id')->unique();
        $studios = Studio::whereIn('id', $studioIds)->get();
        
        // Organize showtimes by studio
        $this->studioShowtimes = [];
        foreach ($studios as $studio) {
            $studioTimes = $this->showtimes->where('studio_id', $studio->id);
            $this->studioShowtimes[$studio->id] = [
                'studio' => $studio,
                'times' => $studioTimes
            ];
        }
    }
    
    public function openTrailer()
    {
        $this->trailerOpen = true;
    }
    
    public function closeTrailer()
    {
        $this->trailerOpen = false;
    }

    public function render()
    {
        return view('livewire.user.detail-film', [
            'film' => $this->film,
            'selectedDate' => $this->selectedDate,
            'availableDates' => $this->availableDates,
            'studioShowtimes' => $this->studioShowtimes,
            'isWeekend' => $this->isWeekend,
        ]);
    }
}
