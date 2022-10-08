<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'imgUrl', 'user_id', 'edition_id'];

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function edition()
    {
        return $this->hasOne(Edition::class);
    }
}
