<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reviews()
    {
        // return $this->hasMany(Review::class, 'user_id');
        return $this->hasMany(Review::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rent::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'gebruiker_id');
    }
    public function receivedReviews()
    {
        return $this->hasManyThrough(Review::class, Product::class, 'gebruiker_id', 'product_id', 'id', 'id');
    }
}
