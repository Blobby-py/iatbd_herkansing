<?php

namespace Database\Factories;

use App\Models\Advertentie;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertentieFactory extends Factory
{
    /**
     * Define the default state of the advertentie model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beschikbareCategorieën = ["elektronica", "meubels", "boeken", "kleding", "gereedschap", "sport", "huishoudelijke apparatuur"];
        $aantalCategorieën = rand(1, 3); // Kies willekeurig tussen 1 en 3 categorieën
        $categorieënLijst = [];

        // Kies willekeurig categorieën
        while (count($categorieënLijst) < $aantalCategorieën) {
            $randomCategorieIndex = array_rand($beschikbareCategorieën);
            $gekozenCategorie = $beschikbareCategorieën[$randomCategorieIndex];

            // Zorg ervoor dat de categorie nog niet is toegevoegd
            if (!in_array($gekozenCategorie, $categorieënLijst)) {
                $categorieënLijst[] = $gekozenCategorie;
            }
        }

        $categorieënString = implode(",", $categorieënLijst);

        return [
            'titel' => $this->faker->sentence(),
            'omschrijving' => $this->faker->paragraph(5),
            'categorie' => $categorieënString,
            'prijs' => $this->faker->randomFloat(2, 10, 500),
            'afbeeldingen' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
            'gebruiker_id' => \App\Models\Gebruiker::factory(),
        ];
    }
}
