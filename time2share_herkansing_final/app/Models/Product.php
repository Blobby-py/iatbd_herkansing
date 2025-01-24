<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'titel', 'omschrijving', 'categorie', 'prijs', 'afbeeldingen', 'gebruiker_id', 'locatie', 'email', 'tags'
    ];
    
    public function scopeFilter($query, array $filters)
    {
        if ($filters['zoekterm'] ?? false) {
            $zoekterm = $filters['zoekterm'];
            $query->where(function($query) use ($zoekterm) {
                $query->where('titel', 'like', '%' . $zoekterm . '%')
                    ->orWhere('omschrijving', 'like', '%' . $zoekterm . '%')
                    ->orWhere('prijs', 'like', '%' . $zoekterm . '%')
                    ->orWhere('locatie', 'like', '%' . $zoekterm . '%')
                    ->orWhere('email', 'like', '%' . $zoekterm . '%')
                    ->orWhere('tags', 'like', '%' . $zoekterm . '%');
            });
        }
    }
    

    public function eigenaar()
    {
        return $this->belongsTo(Gebruiker::class, 'gebruiker_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rent::class);
    }

    public function isRented()
    {
        return $this->rentals()->where('user_id', auth()->id())->exists();
    }
}
