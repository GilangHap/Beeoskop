<?php

namespace App\Livewire\Admin;

use App\Models\Genre as GenreModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

class Genre extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Form properties
    public $genreId = null;
    
    #[Rule('required|min:2|max:50|unique:genres,name')]
    public $name = '';
    
    // UI state properties
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $showModal = false;
    public $confirmingDeletion = false;
    public $deletingId = null;
    
    public function updatingSearch()
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
    
    public function create()
    {
        $this->reset(['genreId', 'name']);
        $this->resetValidation();
        $this->showModal = true;
    }
    
    public function edit($id)
    {
        $this->resetValidation();
        $this->genreId = $id;
        $genre = GenreModel::findOrFail($id);
        $this->name = $genre->name;
        $this->showModal = true;
    }
    
    public function save()
    {
        if ($this->genreId) {
            // For updates, we need a custom validation rule to avoid unique conflicts with the same record
            $this->validate([
                'name' => 'required|min:2|max:50|unique:genres,name,'.$this->genreId
            ]);
            
            $genre = GenreModel::findOrFail($this->genreId);
            $genre->update(['name' => $this->name]);
            $this->dispatch('showAlert', message: 'Genre updated successfully');
        } else {
            $this->validate();
            
            GenreModel::create([
                'name' => $this->name
            ]);
            $this->dispatch('showAlert', message: 'Genre created successfully');
        }
        
        $this->reset(['genreId', 'name', 'showModal']);
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deletingId = $id;
    }
    
    public function deleteGenre()
    {
        $genre = GenreModel::findOrFail($this->deletingId);
        
        // Check if the genre is being used by any films
        if ($genre->films()->count() > 0) {
            $this->dispatch('showAlert', message: 'Cannot delete this genre because it has associated films', type: 'error');
        } else {
            $genre->delete();
            $this->dispatch('showAlert', message: 'Genre deleted successfully');
        }
        
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }
    
    public function cancelDelete()
    {
        $this->confirmingDeletion = false;
        $this->deletingId = null;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['genreId', 'name']);
        $this->resetValidation();
    }
    
    public function render()
    {
        $genres = GenreModel::where('name', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
            
        return view('livewire.admin.genre', [
            'genres' => $genres
        ]);
    }
}
