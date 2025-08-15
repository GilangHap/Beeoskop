<?php

namespace App\Livewire\Admin;

use App\Models\Film as FilmModel;
use App\Models\Genre;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

class Film extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Filtering and sorting properties
    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $filterGenre = '';
    public $filterYear = '';
    public $filterShowing = '';
    public $filterReleaseStatus = ''; // new: unreleased, released
    public $perPage = 10;
    public $confirmingDeletion = false;
    public $deletingId = null;
    
    // Detail modal properties
    public $showDetailModal = false;
    public $detailFilm = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'title'],
        'sortDirection' => ['except' => 'asc'],
        'filterGenre' => ['except' => ''],
        'filterYear' => ['except' => ''],
        'filterShowing' => ['except' => ''],
        'filterReleaseStatus' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterGenre()
    {
        $this->resetPage();
    }
    
    public function updatingFilterYear()
    {
        $this->resetPage();
    }
    
    public function updatingFilterShowing()
    {
        $this->resetPage();
    }
    
    public function updatingFilterReleaseStatus()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function toggleShowingStatus($id)
    {
        $film = FilmModel::findOrFail($id);
        
        // Only allow toggling if the film is released
        if ($film->release_date && $film->release_date->isPast()) {
            $film->update([
                'is_showing' => !$film->is_showing
            ]);
            
            $this->dispatch('showAlert', [
                'message' => 'Film status updated successfully',
                'type' => 'success'
            ]);
        } else {
            $this->dispatch('showAlert', [
                'message' => 'Cannot change status: Film has not been released yet',
                'type' => 'error'
            ]);
        }
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deletingId = $id;
    }
    
    public function deleteFilm()
    {
        try {
            $film = FilmModel::findOrFail($this->deletingId);
            
            // Delete poster if exists
            if ($film->poster_url && str_starts_with($film->poster_url, '/storage/posters/')) {
                // Extract filename from the relative URL path
                $posterFilename = basename($film->poster_url);
                
                // Check if the file exists and delete
                if (Storage::exists('public/posters/' . $posterFilename)) {
                    Storage::delete('public/posters/' . $posterFilename);
                }
            }
            
            // Check if film has any jadwal tayang
            if (method_exists($film, 'jadwalTayangs') && $film->jadwalTayangs()->count() > 0) {
                $this->dispatch('showAlert', [
                    'message' => 'Cannot delete this film because it has scheduled screenings',
                    'type' => 'error'
                ]);
            } else {
                $film->delete();
                $this->dispatch('showAlert', [
                    'message' => 'Film deleted successfully',
                    'type' => 'success'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'message' => 'Error deleting film: ' . $e->getMessage(),
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
    
    public function showDetail($id)
    {
        $this->detailFilm = FilmModel::with('genre')->findOrFail($id);
        $this->showDetailModal = true;
    }
    
    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->detailFilm = null;
    }
    
    public function render()
    {
        $genres = Genre::orderBy('name')->get();
        
        $years = FilmModel::selectRaw('year')
            ->distinct()
            ->whereNotNull('year')
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();
        
        $films = FilmModel::with('genre')
            ->when($this->search, function($query) {
                return $query->where(function($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('producer', 'like', "%{$this->search}%")
                      ->orWhere('sinopsis', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterGenre, function($query) {
                return $query->where('genre_id', $this->filterGenre);
            })
            ->when($this->filterYear, function($query) {
                return $query->where('year', $this->filterYear);
            })
            ->when($this->filterShowing !== '', function($query) {
                return $query->where('is_showing', $this->filterShowing == '1');
            })
            ->when($this->filterReleaseStatus !== '', function($query) {
                $now = now()->toDateString();
                
                if ($this->filterReleaseStatus === 'unreleased') {
                    return $query->where(function($q) use ($now) {
                        $q->where('release_date', '>', $now)
                          ->orWhereNull('release_date');
                    });
                } elseif ($this->filterReleaseStatus === 'released') {
                    return $query->where('release_date', '<=', $now);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.film', [
            'films' => $films,
            'genres' => $genres,
            'years' => $years,
        ]);
    }
}