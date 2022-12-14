<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'publisher', 'language', 'format', 'isStandalone', 'isClosed', 'description', 'ratingAvg', 'characters'
    ];

    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
        // return $this->hasMany(User::class);
    }
}
