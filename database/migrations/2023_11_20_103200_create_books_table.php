<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Funkcija up()
    // Izveido tabulu datubāzē
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('author');
            $table->string('title');
            $table->string('genre');
            $table->decimal('price', 8, 2);
            $table->date('publish_date');
            $table->text('description');
            $table->timestamps();
        });
    }

    // Funkcija down()
    // Atceļ migrāciju
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
