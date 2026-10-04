<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ajustes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',150);
            $table->string('decripcion')->nullable();
            $table->string('direccion');
            $table->string('telefono',20);
            $table->string('email',100);
            $table->string('divisa',50);
            $table->string('url_logo');
            $table->boolean('unico')->default(true)->unique();
            $table->string('web',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
