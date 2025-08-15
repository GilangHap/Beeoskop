<nav class="bg-secondary/95 backdrop-blur-sm text-white fixed top-0 left-0 right-0 z-50 border-b border-gray-800 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo & Navigation Links -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center group">
                    <div class="relative overflow-hidden">
                        <span class="text-2xl font-black tracking-wider text-primary transition-transform duration-500 group-hover:-translate-y-full inline-block">BEE</span>
                        <span class="text-2xl font-black tracking-wider absolute top-0 left-0 text-white transition-transform duration-500 translate-y-full group-hover:translate-y-0 inline-block">BEE</span>
                    </div>
                    <div class="relative overflow-hidden">
                        <span class="text-2xl font-black tracking-wider text-white transition-transform duration-500 group-hover:-translate-y-full inline-block">OSKOP</span>
                        <span class="text-2xl font-black tracking-wider absolute top-0 left-0 text-primary transition-transform duration-500 translate-y-full group-hover:translate-y-0 inline-block">OSKOP</span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-1">
                    <a href="{{ route('home') }}" wire:navigate class="px-3 py-2 rounded-md hover:bg-dark/70 hover:text-primary transition duration-200 font-medium relative group">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('movies') }}" wire:navigate class="px-3 py-2 rounded-md hover:bg-dark/70 hover:text-primary transition duration-200 font-medium relative group">
                        Movies
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('about') }}" wire:navigate class="px-3 py-2 rounded-md hover:bg-dark/70 hover:text-primary transition duration-200 font-medium relative group">
                        About
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>
            </div>
            
            <!-- Auth Menu -->
            <div class="flex items-center space-x-6">
                <!-- Search Icon -->
                <button class="text-gray-300 hover:text-primary transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>

                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 hover:text-primary transition-colors duration-300 bg-dark/60 px-4 py-2 rounded-full">
                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ Auth::user()->username }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200" 
                            x-transition:enter-start="opacity-0 scale-95" 
                            x-transition:enter-end="opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-100" 
                            x-transition:leave-start="opacity-100 scale-100" 
                            x-transition:leave-end="opacity-0 scale-95" 
                            class="absolute right-0 mt-3 w-56 bg-dark rounded-lg shadow-xl py-2 z-50 border border-gray-700 overflow-hidden">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-700">
                                <div class="font-medium text-white">{{ Auth::user()->name ?: Auth::user()->username }}</div>
                                <div class="text-sm text-gray-400 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-1">
                                <a href="{{ route('profile') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    Profile
                                </a>
                                <a href="{{ route('user.transactions') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a1 1 0 011 1v10a1 1 0 01-1 1H2a1 1 0 01-1-1V8a1 1 0 011-1V5zm14 1H4v1h12V6zM4 13a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zm1 2a1 1 0 100 2h10a1 1 0 100-2H5z" clip-rule="evenodd" />
                                    </svg>
                                    My Tickets
                                </a>
                                
                                @if(Auth::user()->role === 'admin')
                                    <div class="border-t border-gray-700 my-1"></div>
                                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @endif
                                
                                <div class="border-t border-gray-700 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-primary w-full text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm11 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L14 12.586V9z" clip-rule="evenodd" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="{{ route('login') }}" wire:navigate class="px-4 py-2 rounded-full border border-gray-700 hover:border-primary hover:text-primary transition duration-300">Login</a>
                        <a href="{{ route('register') }}" wire:navigate class="px-4 py-2 rounded-full bg-primary text-black hover:bg-amber-400 transition duration-300 font-medium">Register</a>
                    </div>
                    
                    <!-- Mobile auth buttons -->
                    <div class="sm:hidden">
                        <a href="{{ route('login') }}" wire:navigate class="text-white hover:text-primary transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                    </div>
                @endauth
                
                <!-- Mobile Menu Button -->
                <button x-data @click="$dispatch('toggle-mobile-menu')" class="md:hidden text-gray-300 hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-10"
        class="fixed top-16 inset-x-0 bg-dark/95 backdrop-blur-md md:hidden z-40">
        <div class="container mx-auto px-4 pt-4 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block py-3 px-4 rounded-md hover:bg-gray-800 hover:text-primary transition duration-200">
                Home
            </a>
            <a href="{{ route('movies') }}" class="block py-3 px-4 rounded-md hover:bg-gray-800 hover:text-primary transition duration-200">
                Movies
            </a>
            <a href="{{ route('about') }}" class="block py-3 px-4 rounded-md hover:bg-gray-800 hover:text-primary transition duration-200">
                About
            </a>
            @guest
                <div class="border-t border-gray-800 my-4 pt-4 flex space-x-3">
                    <a href="{{ route('login') }}" class="flex-1 py-3 px-4 rounded-md border border-gray-700 text-center text-gray-300 hover:border-primary hover:text-primary transition duration-200">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-1 py-3 px-4 rounded-md bg-primary text-center text-black hover:bg-amber-400 transition duration-200 font-medium">
                        Register
                    </a>
                </div>
            @endguest
        </div>
        
        <!-- Yellow accent line -->
        <div class="h-1 bg-primary/30"></div>
    </div>
</nav>