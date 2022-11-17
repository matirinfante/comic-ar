<?php

namespace App\Models;

use App\Models\Booklist;
use App\Models\Comicteca;
use App\Models\Review;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function booklists()
    {
        return $this->hasMany(Booklist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function comictecas()
    {
        return $this->hasOne(Comicteca::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function objnotifications()
    {
        return $this->hasMany(Objnotification::class);
    }
    
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function editions()
    {
        return $this->belongsToMany(Edition::class)->withTimestamps();
    }

    public function badges(){
        return $this->belongsToMany(Badge::class);
    }

}
