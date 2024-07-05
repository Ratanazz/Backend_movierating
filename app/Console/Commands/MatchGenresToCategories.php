<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;
use App\Models\Category;

class MatchGenresToCategories extends Command
{
    protected $signature = 'match:genres-to-categories';
    protected $description = 'Match existing genres in movies to categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Step 1: Create categories based on existing genres
        $genres = Movie::distinct()->pluck('genre');

        foreach ($genres as $genre) {
            Category::firstOrCreate(['name' => $genre], ['description' => 'Category for ' . $genre . ' movies']);
        }

        // Step 2: Update movies to reference categories
        $movies = Movie::all();

        foreach ($movies as $movie) {
            $category = Category::where('name', $movie->genre)->first();
            if ($category) {
                $movie->category_id = $category->id;
                $movie->save();
            }
        }

        $this->info('Genres matched to categories successfully.');
    }
}

