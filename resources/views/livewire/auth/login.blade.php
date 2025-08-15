<div class="bg-dark p-8 rounded-lg shadow-2xl border border-gray-800 relative overflow-hidden">
    <!-- Yellow accent corner -->
    <div class="absolute h-16 w-16 -top-8 -right-8 bg-primary rotate-45"></div>
    
    <h2 class="text-2xl font-bold mb-8 text-white relative z-10">
        USER <span class="text-primary">LOGIN</span>
    </h2>

    <!-- Important: Changed to wire:submit.prevent -->
    <form wire:submit.prevent="submitLogin" class="relative z-10">
        @csrf
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-primary bg-dark/50 p-3 rounded-md border border-primary/30">
                {{ session('status') }}
            </div>
        @endif

        <!-- Email/Username -->
        <div class="mb-5">
            <label for="login" class="block text-gray-300 text-sm font-medium mb-2">Email or Username</label>
            <div class="relative">
                <input wire:model.blur="login" id="login" type="text" 
                    class="bg-gray-900 border-0 appearance-none rounded-md w-full py-3 px-4 text-white leading-tight focus:outline-none focus:ring-2 focus:ring-primary/50 @error('login') ring-2 ring-red-500/50 @enderror" 
                    placeholder="Enter your email or username">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            @error('login')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-300 text-sm font-medium mb-2">Password</label>
            <div class="relative">
                <input wire:model.blur="password" id="password" type="password" 
                    class="bg-gray-900 border-0 appearance-none rounded-md w-full py-3 px-4 text-white leading-tight focus:outline-none focus:ring-2 focus:ring-primary/50 @error('password') ring-2 ring-red-500/50 @enderror" 
                    placeholder="Enter your password">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            @error('password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Remember Me -->
        <div class="mb-6 flex items-center">
            <input wire:model="remember" id="remember" type="checkbox" class="rounded border-gray-700 text-primary focus:ring-primary bg-gray-900">
            <label for="remember" class="ml-2 block text-sm text-gray-300">Remember me</label>
            
            <div class="ml-auto">
                <a href="{{ route('password.request') }}" wire:navigate class="text-sm text-primary hover:text-amber-400 transition-colors">Forgot password?</a>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-6">
            <button type="submit" 
                class="relative w-full bg-primary hover:bg-amber-400 text-black font-bold py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all ease-in-out duration-200 overflow-hidden group"
                wire:loading.attr="disabled">
                <span class="absolute top-0 left-0 w-full h-0 bg-white/30 group-hover:h-full transition-all duration-300 ease-in-out"></span>
                <span wire:loading.remove wire:target="submitLogin" class="relative">LOGIN</span>
                <span wire:loading wire:target="submitLogin" class="relative flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    PROCESSING...
                </span>
            </button>
        </div>
        
        <!-- Debug button -->
        <div class="text-center">
            <button type="button" wire:click="test" class="text-primary hover:underline">
                Test Livewire Action
            </button>
        </div>
    </form>

    <div class="mt-6 text-center relative z-10">
        <p class="text-sm text-gray-400">
            Don't have an account? 
            <a href="{{ route('register') }}" wire:navigate class="text-primary hover:text-amber-400 font-medium transition-colors">Register here</a>
        </p>
    </div>
    
    <!-- Logo at bottom -->
    <div class="mt-8 text-center opacity-30 relative z-10">
        <div class="text-2xl font-black tracking-wider text-primary">BIOSKOP</div>
    </div>
</div>