<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BEEOSKOP') }}</title>
    
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
<body class="bg-secondary min-h-screen flex flex-col text-white">
    <header>
        @livewire('components.navbar')
    </header>
    
    <!-- Main content with proper padding to account for fixed navbar -->
    <main class="flex-grow container mx-auto px-4 py-8 mt-16">
        {{ $slot }}
    </main>
    
    <footer>
        @livewire('components.footer')
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
