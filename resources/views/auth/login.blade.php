<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bioskop</title>
    
    <!-- Styles -->
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
        
    @livewireStyles
</head>
<body class="bg-secondary min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <livewire:auth.login />
    </div>
    
    <!-- Livewire Scripts (and Alpine) -->
    @livewireScripts
    
    <!-- Debug output -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            console.log('Livewire initialized');
        });
    </script>
</body>
</html>