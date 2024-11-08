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
    
    public function scopeZoeken($query, array $filters) 
    {
        if ($filters['categorie'] ?? false) {
            $query->where('categorie', 'like', '%' . request('categorie') . '%');
        }

        if ($filters['zoekterm'] ?? false) {
            $zoekterm = request('zoekterm');
            $query->where(function($query) use ($zoekterm) {
                $query->where('titel', 'like', '%' . $zoekterm . '%')
                    ->orWhere('omschrijving', 'like', '%' . $zoekterm . '%')
                    ->orWhere('categorie', 'like', '%' . $zoekterm . '%');
            });
        }
    }

    public function eigenaar()
    {
        return $this->belongsTo(Gebruiker::class, 'gebruiker_id');
    }
}
