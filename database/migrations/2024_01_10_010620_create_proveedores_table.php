<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Ejecuta la migración
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); // Primary Key: es autoncrementable
            $table->string('nombre',100);
            $table->text('direccion');
            $table->integer('telefono');
            $table->string('correo',50);
            $table->string('password',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // Elimina la migración o table
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
