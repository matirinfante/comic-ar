<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objnotification extends Model
{
    use HasFactory;
    protected $fillable=[
        'id','message','readed','user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
