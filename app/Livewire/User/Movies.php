<?php

namespace App\Livewire\User;

use App\Models\Film;
use App\Models\Genre;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class Movies extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.app')]
    
    public $search = '';
    public $selectedGenre = 'all';
    public $sortBy = 'release_date-desc';
    public $activeTab = 'now-showing';
    public $genreList = [];
    
    // Use Tailwind for pagination
    protected $paginationTheme = 'tailwind';
    
    // Querystring parameters
    protected $queryString = [
        'search' => ['except' => ''],
        'selectedGenre' => ['except' => 'all'],
        'sortBy' => ['except' => 'release_date-desc'],
        'activeTab' => ['except' => 'now-showing'],
        'page' => ['except' => 1],
    ];
    
    public function mount()
    {
        $this->genreList = Genre::orderBy('name')->get();
    }
    
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }
    
    public function setGenre($genre)
    {
        $this->selectedGenre = $genre;
        $this->resetPage();
    }
    
    public function setSorting($sortOption)
    {
        $this->sortBy = $sortOption;
        $this->resetPage();
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        // Basic query
        $query = Film::with('genre');
        
        // Filter by search term
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $this->search . '%')
                  ->orWhere('producer', 'like', '%' . $this->search . '%');
            });
        }
        
        // Filter by genre
        if ($this->selectedGenre !== 'all') {
            $query->where('genre_id', $this->selectedGenre);
        }
        
        // Filter by tab
        if ($this->activeTab === 'now-showing') {
            $query->where('is_showing', true);
        } else {
            $query->where('is_showing', false)
                  ->whereNotNull('release_date')
                  ->where('release_date', '>', Carbon::today());
        }
        
        // Apply sorting
        if ($this->sortBy) {
            [$sortField, $sortDirection] = explode('-', $this->sortBy);
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('release_date', 'desc');
        }
        
        // Get the films with pagination
        $films = $query->paginate(12);
        
        // Count films for tabs
        $nowShowingCount = Film::where('is_showing', true)->count();
        $comingSoonCount = Film::where('is_showing', false)
            ->whereNotNull('release_date')
            ->where('release_date', '>', Carbon::today())
            ->count();
            
        // Debug the SQL query
        Log::info('SQL Query: ' . $query->toSql());
        Log::info('Bindings: ' . json_encode($query->getBindings()));
        Log::info('Film Count: ' . $films->count());
        
        return view('livewire.user.movies', [
            'films' => $films,
            'nowShowingCount' => $nowShowingCount,
            'comingSoonCount' => $comingSoonCount
        ]);
    }
}
