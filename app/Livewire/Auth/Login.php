<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Login extends Component
{
    #[Rule('required|string')]
    public $login = '';
    
    #[Rule('required|string')]
    public $password = '';
    
    public $remember = false;
    
    public function test()
    {
        // Simple test function to verify Livewire actions work
        session()->flash('status', 'Livewire actions are working!');
    }
    
    public function submitLogin()
    {
        logger('Login submission method called with: ' . $this->login);
        
        $validated = $this->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $fieldType = filter_var($this->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [
            $fieldType => $this->login,
            'password' => $this->password
        ];
        
        logger('Attempting login with credentials type: ' . $fieldType);
        
        if (Auth::attempt($credentials, $this->remember)) {
            logger('Login successful for: ' . $this->login);
            session()->regenerate();
            session()->flash('success', 'You have been successfully logged in!');
            return redirect()->intended(route('home'));
        }
        
        logger('Login failed for: ' . $this->login);
        $this->addError('login', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
