<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'progress',
        'steps',
        'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function volumes(){
        return $this->belongsToMany(Volume::class)->withPivot('status');
    }

}
