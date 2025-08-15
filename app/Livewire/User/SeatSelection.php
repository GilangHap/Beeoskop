<?php

namespace App\Livewire\User;

use App\Models\JadwalTayang;
use App\Models\Studio;
use App\Models\Kursi;
use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SeatSelection extends Component
{
    #[Layout('livewire.components.layouts.app')]
    
    public $jadwalId;
    public $jadwal;
    public $selectedSeats = [];
    public $bookedSeats = [];
    
    // Untuk ringkasan pemesanan
    public $film;
    public $studio;
    public $showDate;
    public $showTime;
    public $ticketPrice;
    public $totalPrice = 0;
    
    // Untuk layout kursi
    public $studioSeats = [];
    public $uniqueRows = [];
    public $maxColumn = 0;
    
    public function mount($id)
    {
        $this->jadwalId = $id;
        $this->jadwal = JadwalTayang::with(['film', 'studio'])->findOrFail($id);
        
        // Set data untuk ringkasan pemesanan
        $this->film = $this->jadwal->film;
        $this->studio = $this->jadwal->studio;
        $this->showDate = Carbon::parse($this->jadwal->date)->format('l, d M Y');
        $this->showTime = Carbon::parse($this->jadwal->time_start)->format('H:i');
        $this->ticketPrice = $this->jadwal->price;
        
        // Load kursi studio dari database
        $this->loadStudioSeats();
        
        // Load kursi yang sudah dipesan
        $this->loadBookedSeats();
    }
    
    public function loadStudioSeats()
    {
        // Ambil semua kursi untuk studio ini
        $seats = Kursi::where('studio_id', $this->studio->id)
            ->orderBy('line')
            ->orderBy('coloumn')
            ->get()
            ->toArray();
            
        if (count($seats) === 0) {
            // Jika belum ada data kursi di database, gunakan layout default
            $this->generateDefaultSeats();
            return;
        }
            
        // Transformasi data untuk layout yang lebih mudah
        $this->studioSeats = collect($seats)->groupBy('line');
        
        // Dapatkan semua baris yang unik
        $this->uniqueRows = collect($seats)->pluck('line')->unique()->values()->toArray();
        
        // Dapatkan jumlah kolom maksimal
        $this->maxColumn = collect($seats)->max('coloumn');
    }
    
    public function generateDefaultSeats()
    {
        // Buat layout kursi default berdasarkan kapasitas studio
        $capacity = $this->studio->capacity ?? 60;
        
        // Gunakan abjad untuk line/baris
        $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $seatsPerRow = 8;
        
        if ($capacity > 64) {
            $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            $seatsPerRow = 10;
        } else if ($capacity < 48) {
            $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
            $seatsPerRow = 8;
        }
        
        $defaultSeats = [];
        
        foreach ($rows as $row) {
            $rowSeats = [];
            for ($col = 1; $col <= $seatsPerRow; $col++) {
                $rowSeats[] = [
                    'id' => null,
                    'studio_id' => $this->studio->id,
                    'chair_number' => $row . $col, // Format kursi: A1, A2, B1, dst
                    'line' => $row, // Line menggunakan abjad
                    'coloumn' => $col
                ];
            }
            $defaultSeats[$row] = $rowSeats;
        }
        
        $this->studioSeats = collect($defaultSeats);
        $this->uniqueRows = $rows;
        $this->maxColumn = $seatsPerRow;
    }
    
    public function loadBookedSeats()
    {
        // Ambil semua tiket yang sudah dipesan untuk jadwal ini
        $bookedTickets = Tiket::where('jadwal_tayang_id', $this->jadwalId)->get();
        
        // Ambil kursi_id dan konversikan ke seat_number
        $this->bookedSeats = [];
        foreach ($bookedTickets as $ticket) {
            if ($ticket->kursi) {
                $this->bookedSeats[] = $ticket->kursi->chair_number;
            }
        }
    }
    
    public function toggleSeat($seatNumber)
    {
        // Jika kursi sudah dipesan, tidak bisa dipilih
        if (in_array($seatNumber, $this->bookedSeats)) {
            return;
        }
        
        // Toggle seat selection
        if (in_array($seatNumber, $this->selectedSeats)) {
            // Remove seat
            $this->selectedSeats = array_diff($this->selectedSeats, [$seatNumber]);
        } else {
            // Add seat (maksimal 6 kursi)
            if (count($this->selectedSeats) < 6) {
                $this->selectedSeats[] = $seatNumber;
            } else {
                $this->dispatch('showAlert', [
                    'message' => 'You can only select up to 6 seats',
                    'type' => 'warning'
                ]);
            }
        }
        
        // Sort selected seats for better display
        sort($this->selectedSeats);
        
        // Update total price
        $this->totalPrice = count($this->selectedSeats) * $this->ticketPrice;
    }
    
    public function proceedToCheckout()
    {
        if (empty($this->selectedSeats)) {
            $this->dispatch('showAlert', [
                'message' => 'Please select at least one seat',
                'type' => 'error'
            ]);
            return;
        }
        
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            session(['redirect_after_login' => route('seat.selection', $this->jadwalId)]);
            $this->dispatch('showAlert', [
                'message' => 'Please login to continue booking',
                'type' => 'info'
            ]);
            return redirect()->route('login');
        }
        
        // Save selected seats to session and redirect to checkout
        session(['selected_seats' => $this->selectedSeats]);
        session(['jadwal_id' => $this->jadwalId]);
        
        return redirect()->route('checkout');
    }
    
    public function render()
    {
        return view('livewire.user.seat-selection');
    }
}