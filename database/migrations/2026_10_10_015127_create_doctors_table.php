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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('restrict');
            $table->string('nombres',200);
            $table->string('apellidos',200);
            $table->enum('tipo_documento',['CI','CE','PASAPORTE']);
            $table->string('numero_documento',30);
            $table->date('fecha_nacimiento');
            $table->enum('genero',['M','F']);
            $table->text('direccion');
            $table->string('telefono',30);
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->string('colegiatura',150);
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('fotografia')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
