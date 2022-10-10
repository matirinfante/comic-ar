<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comicteca;

class Volume extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'number', 'ISBN', 'argument', 'coverImage', 'edition_id'
    ];

    public function edition(){
        return $this->belongsTo(Edition::class, 'edition_id');
    }
    
    public function wishlists(){
        return $this->belongsToMany(Wishlist::class)->withTimestamps();
    }
    
    public function comictecas(){
        return $this->belongsToMany(Comicteca::class,'comicteca_volume','volume_id','comicteca_id');
    }
    
    public function objectives(){
        return $this->belongsToMany(Objective::class)->withPivot('status');
    }

}
