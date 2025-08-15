<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'BEEOSKOP') }} - Admin Panel</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FFCC00', // Bright yellow
                        secondary: '#121212', // Dark background
                        dark: '#1A1A1A',     // Slightly lighter black for cards
                    }
                }
            }
        }
    </script>
    
    <!-- Livewire Styles -->
    @livewireStyles

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-y-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-secondary min-h-screen text-white" x-data="{ sidebarOpen: true }">
    <!-- Admin Navbar -->
    <header class="fixed top-0 inset-x-0 z-50 bg-dark border-b border-gray-800">
        <div class="flex items-center justify-between h-16 px-4">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <div class="bg-primary/20 rounded-lg p-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm9 4a1 1 0 10-2 0v6a1 1 0 102 0V7zm-3 2a1 1 0 10-2 0v4a1 1 0 102 0V9zm-3 3a1 1 0 10-2 0v1a1 1 0 102 0v-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-white hidden md:inline-block">BEE<span class="text-primary">OSKOP</span> Admin</span>
                </a>
            </div>
            
            <!-- Right Navigation -->
            <div class="flex items-center space-x-4">
                <!-- Search Button -->
                <button class="p-1 text-gray-400 hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="p-1 text-gray-400 hover:text-primary transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95" 
                        x-transition:enter-end="opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-100" 
                        x-transition:leave-start="opacity-100 scale-100" 
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-80 bg-dark border border-gray-700 rounded-lg shadow-xl overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-700">
                            <h3 class="text-sm font-medium">Notifications</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <a href="#" class="flex px-4 py-3 hover:bg-gray-800 border-b border-gray-700">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm">New booking received</p>
                                    <p class="text-xs text-gray-500 mt-1">John Doe booked 3 tickets for Avengers</p>
                                    <p class="text-xs text-gray-500 mt-1">5 minutes ago</p>
                                </div>
                            </a>
                            <a href="#" class="flex px-4 py-3 hover:bg-gray-800 border-b border-gray-700">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm">System alert: Low storage</p>
                                    <p class="text-xs text-gray-500 mt-1">Server space is running low. Please check.</p>
                                    <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 border-t border-gray-700">
                            <a href="#" class="text-xs text-primary hover:underline block text-center">View all notifications</a>
                        </div>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-2 hover:text-primary transition-colors">
                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="hidden md:inline-block font-medium">{{ Auth::user()->name ?? 'Admin User' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <!-- User Dropdown -->
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95" 
                        x-transition:enter-end="opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-100" 
                        x-transition:leave-start="opacity-100 scale-100" 
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-dark border border-gray-700 rounded-lg shadow-xl overflow-hidden z-50">
                        <div class="px-4 py-3 border-b border-gray-700">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-gray-500 truncate mt-1">{{ Auth::user()->email ?? 'admin@beeoskop.com' }}</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-800 text-gray-300 hover:text-white">
                            Profile Settings
                        </a>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm hover:bg-gray-800 text-gray-300 hover:text-white">
                            View Frontend
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-700">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-800 text-gray-300 hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex h-full pt-16">
        <!-- Sidebar -->
        <livewire:components.sidebar />
        
        <!-- Content Area -->
        <div class="flex-1 transition-all duration-300" 
             :class="sidebarOpen ? 'md:pl-64' : 'md:pl-20'">
            <main class="px-4 py-8">
                <!-- Page Content -->
                <div>
                    {{ $slot }}
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="px-4 py-6 border-t border-gray-800">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500">
                            &copy; {{ date('Y') }} BEEOSKOP. All rights reserved.
                        </div>
                        <div class="text-sm text-gray-500 mt-2 md:mt-0">
                            Admin Panel v1.0
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('showAlert', (message, type = 'success') => {
                // You can implement a toast notification system here
                console.log(type + ': ' + message);
            });
        });
    </script>
</body>
</html>