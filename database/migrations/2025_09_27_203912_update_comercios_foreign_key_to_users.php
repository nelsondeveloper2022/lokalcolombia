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
        Schema::table('tMarketComerciosServicios', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea existente
            $table->dropForeign('tmarketcomerciosservicios_ibfk_1');
            
            // Crear nueva restricción de clave foránea que apunte a users
            $table->foreign('idUsuarioCreacion')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tMarketComerciosServicios', function (Blueprint $table) {
            // Eliminar la restricción actual
            $table->dropForeign(['idUsuarioCreacion']);
            
            // Restaurar la restricción original (asumiendo que tUsuario existe)
            $table->foreign('idUsuarioCreacion')->references('idUsuario')->on('tUsuario')->onDelete('set null');
        });
    }
};
