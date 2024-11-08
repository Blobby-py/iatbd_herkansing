<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak een testgebruiker aan
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@user.com'
        ]);

        // Maak 14 producten aan voor de testgebruiker
        Product::factory(14)->create([
            'gebruiker_id' => $user->id  // Let op, 'gebruiker_id' in plaats van 'user_id'
        ]);
    }
}
