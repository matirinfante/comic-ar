<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'description', 'edition_id', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function edition()
    {
        return $this->hasOne(Edition::class);
    }
}
