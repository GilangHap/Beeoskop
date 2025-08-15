<?php

namespace App\Livewire\Admin;

use App\Models\Studio as StudioModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class Studio extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Form properties
    public $studioId;
    public $name = '';
    public $capacity = 0;
    
    // UI state properties
    public $isModalOpen = false;
    public $isEditMode = false;
    public $confirmingDeletion = false;
    public $deletingId = null;
    public $search = '';
    
    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'capacity' => 'required|integer|min:1|max:500',
    ];
    
    public function openModal($mode = 'create', $id = null)
    {
        $this->reset(['name', 'capacity', 'studioId']);
        $this->isModalOpen = true;
        $this->isEditMode = $mode === 'edit';
        
        if ($this->isEditMode && $id) {
            $this->studioId = $id;
            $studio = StudioModel::findOrFail($id);
            $this->name = $studio->name;
            $this->capacity = $studio->capacity;
        }
    }
    
    public function closeModal()
    {
        $this->isModalOpen = false;
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->isEditMode) {
            $studio = StudioModel::findOrFail($this->studioId);
            $studio->update([
                'name' => $this->name,
                'capacity' => $this->capacity,
            ]);
            
            $message = 'Studio updated successfully';
        } else {
            StudioModel::create([
                'name' => $this->name,
                'capacity' => $this->capacity,
            ]);
            
            $message = 'Studio created successfully';
        }
        
        $this->closeModal();
        $this->dispatch('showAlert', [
            'message' => $message,
            'type' => 'success'
        ]);
    }
    
    public function confirmDelete($id)
    {
        $this->confirmingDeletion = true;
        $this->deletingId = $id;
    }
    
    public function deleteStudio()
    {
        $studio = StudioModel::findOrFail($this->deletingId);
        
        // Check if studio has any jadwal tayang
        if ($studio->jadwalTayangs()->count() > 0) {
            $this->dispatch('showAlert', [
                'message' => 'Cannot delete this studio because it has scheduled screenings',
                'type' => 'error'
            ]);
        } else {
            // Delete the studio and associated seats
            $studio->kursis()->delete();
            $studio->delete();
            
            $this->dispatch('showAlert', [
                'message' => 'Studio deleted successfully',
                'type' => 'success'
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
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $studios = StudioModel::when($this->search, function($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('kursis as seat_count')
            ->withCount('jadwalTayangs as schedule_count')
            ->orderBy('name')
            ->paginate(10);
        
        return view('livewire.admin.studio', [
            'studios' => $studios,
        ]);
    }
}
