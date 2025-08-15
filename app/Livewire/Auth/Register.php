<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Rule;

class Register extends Component
{
    #[Rule('required|min:3|max:50|unique:users,username')]
    public $username = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public $email = '';

    #[Rule('required|min:8|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate();
        
        $user = User::create([
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'customer', // Default role
        ]);

        Auth::login($user);

        session()->flash('success', 'Registration successful! Welcome to Bioskop.');

        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
