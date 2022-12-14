<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function edition(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function volumes(){
        return $this->belongsToMany(Volume::class)->withTimestamps()->orderBy('title')->orderBy('number');
    }

    
}
