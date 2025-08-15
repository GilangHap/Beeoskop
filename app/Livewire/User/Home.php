<?php

namespace App\Livewire\User;

use App\Models\Film;
use App\Models\Genre;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Home extends Component
{
    #[Layout('livewire.components.layouts.app')]
    
    public function render()
    {
        // Get featured films (those that are showing with recent release dates)
        $featuredFilms = Film::where('is_showing', true)
            ->whereNotNull('release_date')
            ->orderBy('release_date', 'desc')
            ->limit(5)
            ->get();
            
        // Get now showing films - films with is_showing = true
        $nowShowingFilms = Film::where('is_showing', true)
            ->orderBy('release_date', 'desc')
            ->limit(8)
            ->get();
            
        // Get coming soon films - ONLY films with future release dates AND not currently showing
        $comingSoonFilms = Film::where('is_showing', false) // Important: must not be currently showing
            ->whereNotNull('release_date')
            ->where('release_date', '>', Carbon::today())
            ->orderBy('release_date', 'asc')
            ->limit(4)
            ->get();

        // If we don't have enough coming soon films, create placeholders only if needed
        if ($comingSoonFilms->count() < 4) {
            // Get films that are not already in coming soon or now showing
            $usedFilmIds = $comingSoonFilms->pluck('id')
                ->merge($nowShowingFilms->pluck('id'));
                
            $additionalFilms = Film::whereNotIn('id', $usedFilmIds)
                ->limit(4 - $comingSoonFilms->count())
                ->get()
                ->map(function($film) {
                    // Clone the film to avoid modifying the original model
                    $newFilm = clone $film;
                    
                    // Create a future release date between 1-6 months from now
                    $futureMonths = rand(1, 6);
                    $futureDate = Carbon::now()->addMonths($futureMonths);
                    $newFilm->release_date = $futureDate;
                    
                    // Ensure it's marked as not showing
                    $newFilm->is_showing = false;
                    
                    return $newFilm;
                });
                
            // Merge the additional films with the actual coming soon films
            $comingSoonFilms = $comingSoonFilms->concat($additionalFilms);
        }
            
        // Get popular genres
        $popularGenres = Genre::withCount('films')
            ->orderBy('films_count', 'desc')
            ->limit(6)
            ->get();
        
        return view('livewire.user.home', [
            'featuredFilms' => $featuredFilms,
            'nowShowingFilms' => $nowShowingFilms,
            'comingSoonFilms' => $comingSoonFilms,
            'popularGenres' => $popularGenres,
        ]);
    }
}
