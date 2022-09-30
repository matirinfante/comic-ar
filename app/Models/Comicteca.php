<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comicteca extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function volumes(){
        return $this->hasMany(Volume::class);
    }
}
