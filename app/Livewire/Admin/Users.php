<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;
    
    #[Layout('livewire.components.layouts.admin')]
    
    // Filtering and sorting properties
    public $search = '';
    public $sortField = 'username';
    public $sortDirection = 'asc';
    public $perPage = 10;
    
    // User properties for edit
    public $userId;
    public $username;
    public $email;
    public $role = 'customer';
    public $password;
    public $password_confirmation;
    
    // Modal states
    public $isEditModalOpen = false;
    public $isViewModalOpen = false;
    public $isDeleteModalOpen = false;
    public $selectedUser = null;
    
    protected function rules()
    {
        return [
            'username' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|in:customer,admin',
            'password' => 'nullable|min:8|confirmed',
        ];
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
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
    
    public function openViewModal($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->isViewModalOpen = true;
    }
    
    public function closeViewModal()
    {
        $this->isViewModalOpen = false;
        $this->selectedUser = null;
    }
    
    public function openEditModal($id)
    {
        $this->reset('password', 'password_confirmation');
        $user = User::findOrFail($id);
        
        $this->userId = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
        
        $this->isEditModalOpen = true;
    }
    
    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
        $this->resetValidation();
    }
    
    public function confirmDelete($id)
    {
        $this->userId = $id;
        $this->selectedUser = User::findOrFail($id);
        $this->isDeleteModalOpen = true;
    }
    
    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->selectedUser = null;
    }
    
    public function updateUser()
    {
        $this->validate();
        
        $user = User::findOrFail($this->userId);
        
        $userData = [
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
        ];
        
        // Only update password if provided
        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }
        
        $user->update($userData);
        
        $this->dispatch('showAlert', [
            'message' => 'User updated successfully',
            'type' => 'success'
        ]);
        
        $this->isEditModalOpen = false;
    }
    
    public function deleteUser()
    {
        $user = User::findOrFail($this->userId);
        
        // Check if user has related data
        if ($user->orders()->count() > 0) {
            $this->dispatch('showAlert', [
                'message' => 'Cannot delete user with existing orders',
                'type' => 'error'
            ]);
            $this->isDeleteModalOpen = false;
            return;
        }
        
        $user->delete();
        
        $this->dispatch('showAlert', [
            'message' => 'User deleted successfully',
            'type' => 'success'
        ]);
        
        $this->isDeleteModalOpen = false;
    }
    
    public function render()
    {
        $users = User::where('role', '!=', 'admin')
            ->when($this->search, function($query) {
                return $query->where(function($query) {
                    $query->where('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        
        return view('livewire.admin.users', [
            'users' => $users,
        ]);
    }
}
