<?php

namespace App\Livewire\Admin;

use App\Models\Film;
use App\Models\Genre;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmForm extends Component
{
    use WithFileUploads;
    
    #[Layout('livewire.components.layouts.admin')]
    
    public ?Film $film = null;
    
    // Form fields
    #[Rule('required|string|max:255')]
    public $title = '';
    
    #[Rule('nullable|string|max:255')]
    public $producer = '';
    
    #[Rule('required|integer|min:1900|max:2099')]
    public $year;
    
    #[Rule('required|integer|min:1')]
    public $duration = 0;
    
    #[Rule('nullable|string')]
    public $sinopsis = '';
    
    #[Rule('required|exists:genres,id')]
    public $genre_id;
    
    public $is_showing = false;
    
    #[Rule('nullable|date')]
    public $release_date;
    
    #[Rule('nullable|image|max:2048')]
    public $poster;
    
    public $poster_url;
    
    public $pageTitle;
    public $isEditing = false;
    public $showAlert = false;
    public $alertType = 'success';
    public $alertMessage = '';
    public $canToggleShowing = false;
    
    public function mount($id = null)
    {
        $this->pageTitle = $id ? 'Edit Film' : 'Add New Film';
        $this->isEditing = $id ? true : false;
        
        if ($id) {
            $this->film = Film::findOrFail($id);
            $this->title = $this->film->title;
            $this->producer = $this->film->producer;
            $this->year = $this->film->year;
            $this->duration = $this->film->duration;
            $this->sinopsis = $this->film->sinopsis;
            $this->genre_id = $this->film->genre_id;
            $this->is_showing = $this->film->is_showing;
            $this->poster_url = $this->film->poster_url;
            $this->release_date = $this->film->release_date ? $this->film->release_date->format('Y-m-d') : null;
            
            // Check if release date has passed to enable manual toggle
            $this->canToggleShowing = $this->film->release_date && $this->film->release_date->isPast();
        } else {
            // Set default values for new film
            $this->year = date('Y');
            $this->film = new Film();
            $this->is_showing = false;
            $this->canToggleShowing = false;
        }
    }
    
    public function updatedReleaseDate()
    {
        if (!empty($this->release_date)) {
            $releaseDate = Carbon::parse($this->release_date);
            
            // Set is_showing to true if release date has passed
            if ($releaseDate->isPast()) {
                $this->is_showing = true;
                $this->canToggleShowing = true;
            } else {
                $this->is_showing = false;
                $this->canToggleShowing = false;
            }
        } else {
            $this->is_showing = false;
            $this->canToggleShowing = false;
        }
    }
    
    public function save()
    {
        $this->validate();
        
        try {
            // Debug: Check if storage directories are writable
            Log::debug('Storage path: ' . storage_path());
            Log::debug('Public storage path: ' . Storage::disk('public')->path(''));
            Log::debug('Is public disk writable: ' . (is_writable(Storage::disk('public')->path('')) ? 'Yes' : 'No'));
            
            // Prepare data for saving
            $data = [
                'title' => $this->title,
                'producer' => $this->producer,
                'year' => $this->year,
                'duration' => $this->duration,
                'sinopsis' => $this->sinopsis,
                'genre_id' => $this->genre_id,
                'release_date' => $this->release_date,
            ];
            
            // Set is_showing based on release date
            if (!empty($this->release_date)) {
                $releaseDate = Carbon::parse($this->release_date);
                if ($releaseDate->isPast()) {
                    // If already released, respect manual toggle
                    $data['is_showing'] = $this->is_showing;
                } else {
                    // If not yet released, force to false
                    $data['is_showing'] = false;
                }
            } else {
                $data['is_showing'] = false;
            }
            
            // Handle poster upload if provided
            if ($this->poster) {
                // Debug poster information
                Log::debug('Poster object: ' . get_class($this->poster));
                Log::debug('Poster original name: ' . $this->poster->getClientOriginalName());
                Log::debug('Poster mime type: ' . $this->poster->getMimeType());
                Log::debug('Poster size: ' . $this->poster->getSize());
                
                // Create posters directory if it doesn't exist
                if (!Storage::disk('public')->exists('posters')) {
                    Storage::disk('public')->makeDirectory('posters');
                    Log::debug('Created posters directory');
                }
                
                // Delete old poster if exists
                if ($this->isEditing && $this->film->poster_url) {
                    try {
                        Log::debug('Old poster URL: ' . $this->film->poster_url);
                        
                        // Extract filename from URL
                        $oldFilename = basename($this->film->poster_url);
                        
                        // Check if file exists in storage
                        if (Storage::disk('public')->exists('posters/' . $oldFilename)) {
                            Storage::disk('public')->delete('posters/' . $oldFilename);
                            Log::debug('Deleted old poster: posters/' . $oldFilename);
                        } else {
                            Log::debug('Old poster file not found in storage');
                        }
                    } catch (\Exception $e) {
                        Log::error('Error deleting old poster: ' . $e->getMessage());
                    }
                }
                
                // Generate a unique filename with safe characters
                $extension = $this->poster->getClientOriginalExtension();
                $filename = time() . '_' . Str::slug(pathinfo($this->poster->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                
                try {
                    // Store the file using the public disk
                    $path = $this->poster->storeAs('posters', $filename, 'public');
                    Log::debug('Stored poster to path: ' . $path . ' on disk: public');
                    
                    // Set the URL with the correct public path
                    $data['poster_url'] = '/storage/' . $path;
                    Log::debug('Set poster_url to: ' . $data['poster_url']);
                } catch (\Exception $e) {
                    Log::error('Error storing poster: ' . $e->getMessage());
                    throw $e; // Re-throw to handle in the main catch block
                }
            }
            
            // Save film
            if ($this->isEditing) {
                $this->film->update($data);
                $this->alertMessage = 'Film updated successfully!';
            } else {
                $this->film = Film::create($data);
                $this->alertMessage = 'Film added successfully!';
            }
            
            $this->alertType = 'success';
            $this->showAlert = true;
            
            // After successful save, redirect to the film listing page
            return redirect()->route('admin.film');
            
        } catch (\Exception $e) {
            Log::error('Error saving film: ' . $e->getMessage());
            $this->alertType = 'error';
            $this->alertMessage = 'Error: ' . $e->getMessage();
            $this->showAlert = true;
        }
    }
    
    public function render()
    {
        $genres = Genre::orderBy('name')->get();
        
        return view('livewire.admin.film-form', [
            'genres' => $genres
        ]);
    }
}