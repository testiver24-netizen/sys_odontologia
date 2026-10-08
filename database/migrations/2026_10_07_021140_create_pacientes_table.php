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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombres',150);
            $table->string('apellidos',150);
            $table->enum('tipo_documento',['CI','CE','PASAPORTE']);
            $table->string('numero_documento',20)->unique();
            $table->date('fecha_nacimiento',20);
            $table->enum('genero',['M','F']);
            $table->string('direccion');
            $table->string('telefono',20); 
            // $table->string('email',50); 
            $table->enum('grupo_sanguineo',['A+','A-','B+','B-','AB+','AB-','O+','O-'])->nullable(); 
            $table->string('alergias')->nullable(); 
            $table->string('enfermedades')->nullable(); 
            $table->string('medicamentos')->nullable(); 
            $table->string('habitos')->nullable(); 
            $table->string('antecedentes')->nullable(); 
            $table->json('odontograma')->nullable(); 
            $table->string('contacto_emergencia',150)->nullable(); 
            $table->string('telefono_emergencia')->nullable(); 
            $table->text('observaciones')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
