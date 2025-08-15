<aside class="fixed top-16 left-0 bottom-0 w-64 bg-dark border-r border-gray-800 shadow-lg transition-all duration-300 z-40 overflow-hidden" 
    x-data="{ isOpen: true }" 
    :class="isOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0 md:w-20'">
    
    <!-- Sidebar Header with Toggle -->
    <div class="flex items-center justify-between p-4 border-b border-gray-800">
        <div class="flex items-center space-x-3" :class="!isOpen && 'md:justify-center md:w-full'">
            <div class="flex-shrink-0 w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div :class="!isOpen && 'md:hidden'">
                <h2 class="font-bold text-white text-xl">Admin</h2>
                <p class="text-xs text-gray-500">Management Panel</p>
            </div>
        </div>
        
        <!-- Toggle Button -->
        <button @click="isOpen = !isOpen" class="md:hidden text-gray-400 hover:text-primary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>
        
        <!-- Desktop Toggle Button -->
        <button @click="isOpen = !isOpen" class="hidden md:block text-gray-400 hover:text-primary transition-colors">
            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    
    <!-- Navigation Wrapper with Hidden Scrollbar -->
    <div class="h-[calc(100%-64px-65px)] overflow-y-auto scrollbar-hide">
        <!-- Main Navigation -->
        <div class="px-2 py-4">
            <!-- Dashboard -->
            <div class="mb-2">
                <p class="px-4 py-2 text-xs font-semibold uppercase text-gray-500" :class="!isOpen && 'md:hidden'">
                    Main
                </p>
                <a wire:navigate href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Dashboard</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Dashboard
                    </span>
                </a>
            </div>
            
            <!-- Content Management -->
            <div class="mb-2">
                <p class="px-4 py-2 text-xs font-semibold uppercase text-gray-500" :class="!isOpen && 'md:hidden'">
                    Content
                </p>
                
                <a wire:navigate href="{{ route('admin.film') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.film*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.film*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Movies</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Movies
                    </span>
                </a>
                
                <a wire:navigate href="{{ route('admin.screenings') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.screenings*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.screenings*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Screenings</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Screenings
                    </span>
                </a>
                
                <a wire:navigate href="{{ route('admin.studio') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.studio*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.studio*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Theaters</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Theaters
                    </span>
                </a>
                
                <a wire:navigate href="{{ route('admin.genre') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.genre*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.genre*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Genres</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Genres
                    </span>
                </a>
            </div>
            
            <!-- User Management -->
            <div class="mb-2">
                <p class="px-4 py-2 text-xs font-semibold uppercase text-gray-500" :class="!isOpen && 'md:hidden'">
                    Users
                </p>
                
                <a wire:navigate href="{{ route('admin.users') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.users*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.users*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Users</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Users
                    </span>
                </a>
            </div>
            
            <!-- Transaction Management -->
            <div class="mb-2">
                <p class="px-4 py-2 text-xs font-semibold uppercase text-gray-500" :class="!isOpen && 'md:hidden'">
                    Transactions
                </p>
                
                <a wire:navigate href="{{ route('admin.verification') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.verification*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.verification*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Payment Verification</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Verification
                    </span>
                </a>
                
                <a wire:navigate href="{{ route('admin.transactions') }}" 
                class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-800 hover:text-white transition-colors group
                        {{ request()->routeIs('admin.transactions*') ? 'bg-primary/10 text-primary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('admin.transactions*') ? 'text-primary' : 'text-gray-400 group-hover:text-white' }}" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-200" :class="!isOpen && 'md:hidden'">Transactions</span>
                    <span x-cloak x-show="!isOpen" class="absolute left-0 ml-6 px-2 py-0.5 text-xs font-medium bg-dark text-white rounded-md opacity-0 -translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                        Transactions
                    </span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Sidebar Footer -->
    <div class="border-t border-gray-800 p-4">
        <div class="flex items-center" :class="!isOpen && 'justify-center'">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
            <div class="ml-3" :class="!isOpen && 'md:hidden'">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@beeoskop.com' }}</p>
            </div>
            <div class="ml-auto" :class="!isOpen && 'md:hidden'">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-primary transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V4a1 1 0 00-1-1H3zm10 1h1a1 1 0 011 1v10a1 1 0 01-1 1h-1V4z" clip-rule="evenodd" />
                            <path d="M7 8a1 1 0 011-1h2a1 1 0 110 2H9v2a1 1 0 01-2 0V8z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Backdrop -->
    <div x-cloak x-show="isOpen" @click="isOpen = false" 
         class="md:hidden fixed inset-0 bg-black/50 z-30">
    </div>

    <!-- Toggle Button Outside (Mobile) -->
    <button @click="isOpen = !isOpen" 
            class="md:hidden fixed bottom-6 right-6 z-50 bg-primary text-black w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</aside>