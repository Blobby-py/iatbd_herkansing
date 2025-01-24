<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebruiker_id')->constrained('users')->onDelete('cascade');
            $table->string('titel');
            $table->string('locatie');
            $table->string('email');
            $table->string('tags')->nullable();
            $table->decimal('prijs', 10, 2);
            $table->string('afbeeldingen')->nullable();
            $table->longText('omschrijving')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
