<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
use HasFactory;

   protected $fillable = [
       'name',
       'summary',
       'genre',
       'release_date',
       'rating',
       'runtime_minutes',
       'image_poster',
       'trailer',
       'rated_type',
       'director',
       'wrtitter',
       'production',
   ];
   public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
//For fetch comment from youtube it extract video id from Trailer url
public function getYoutubeVideoIdAttribute()
    {
        $url = $this->trailer;
        $parsedUrl = parse_url($url);

        // Extract the video ID from the path of the embed URL
        if (isset($parsedUrl['path']) && strpos($parsedUrl['path'], '/embed/') === 0) {
            $pathSegments = explode('/', $parsedUrl['path']);
            return $pathSegments[2] ?? null;
        }

        return null;
    }

    protected $appends = ['youtube_video_id'];
}

