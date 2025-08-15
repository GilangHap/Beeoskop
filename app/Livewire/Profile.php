<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Component
{
    #[Layout('livewire.components.layouts.app')]
    
    // User profile data
    public $name;
    public $username;
    public $email;
    public $phone;
    
    // Password change
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    
    // UI state
    public $isEditingProfile = false;
    public $isChangingPassword = false;
    public $successMessage = '';
    
    public function mount()
    {
        $user = auth()->user();
        
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }
    
    public function startEditingProfile()
    {
        $this->isEditingProfile = true;
    }
    
    public function cancelEditingProfile()
    {
        $this->isEditingProfile = false;
        $this->mount(); // Reset to original values
    }
    
    public function toggleChangePassword()
    {
        $this->isChangingPassword = !$this->isChangingPassword;
        if (!$this->isChangingPassword) {
            $this->resetPasswordFields();
        }
    }
    
    public function resetPasswordFields()
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
    }
    
    public function updateProfile()
    {
        $user = auth()->user();
        
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->name = $this->name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone = $this->phone;
        
        $user->save();
        
        $this->isEditingProfile = false;
        $this->successMessage = 'Profile updated successfully!';
        
        $this->dispatch('profile-updated');
        $this->dispatch('notify', [
            'message' => 'Profile updated successfully!',
            'type' => 'success'
        ]);
    }
    
    public function changePassword()
    {
        $validated = $this->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);
        
        $user = auth()->user();
        
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }
        
        $user->password = Hash::make($this->new_password);
        $user->save();
        
        $this->resetPasswordFields();
        $this->isChangingPassword = false;
        $this->successMessage = 'Password changed successfully!';
        
        $this->dispatch('password-updated');
        $this->dispatch('notify', [
            'message' => 'Password changed successfully!',
            'type' => 'success'
        ]);
    }
    
    public function render()
    {
        return view('livewire.profile');
    }
}