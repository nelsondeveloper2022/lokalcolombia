<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar tabla tMarketComerciosServicios
        Schema::table('tMarketComerciosServicios', function (Blueprint $table) {
            // Cambiar campo estado a enum string
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'eliminado'])
                ->default('pendiente')
                ->change();
        });

        // Actualizar tabla tMarketComerciosServiciosInformacion
        Schema::table('tMarketComerciosServiciosInformacion', function (Blueprint $table) {
            // Cambiar campo estado a enum string
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'eliminado'])
                ->default('pendiente')
                ->change();
        });

        // Actualizar registros existentes (convertir números a strings)
        DB::table('tMarketComerciosServicios')->update([
            'estado' => DB::raw("CASE 
                WHEN estado = 0 THEN 'eliminado'
                WHEN estado = 1 THEN 'pendiente' 
                WHEN estado = 2 THEN 'aprobado'
                WHEN estado = 3 THEN 'rechazado'
                ELSE 'pendiente'
            END")
        ]);

        DB::table('tMarketComerciosServiciosInformacion')->update([
            'estado' => DB::raw("CASE 
                WHEN estado = 0 THEN 'eliminado'
                WHEN estado = 1 THEN 'pendiente' 
                WHEN estado = 2 THEN 'aprobado'
                WHEN estado = 3 THEN 'rechazado'
                ELSE 'pendiente'
            END")
        ]);

        // Asegurar CASCADE DELETE en imágenes
        Schema::table('tMarketComercioServicioImagenes', function (Blueprint $table) {
            // Primero eliminar la restricción existente si existe
            try {
                $table->dropForeign(['idMarketComerciosServicios']);
            } catch (Exception $e) {
                // Si no existe, continuar
            }

            // Crear nueva restricción con CASCADE DELETE
            $table->foreign('idMarketComerciosServicios')
                ->references('idMarketComerciosServicios')
                ->on('tMarketComerciosServicios')
                ->onDelete('cascade');
        });

        // Asegurar CASCADE DELETE en datos de contacto
        Schema::table('tMarketComerciosServiciosDatosContacto', function (Blueprint $table) {
            // Primero eliminar la restricción existente si existe
            try {
                $table->dropForeign(['idMarketComerciosServicios']);
            } catch (Exception $e) {
                // Si no existe, continuar
            }

            // Crear nueva restricción con CASCADE DELETE
            $table->foreign('idMarketComerciosServicios')
                ->references('idMarketComerciosServicios')
                ->on('tMarketComerciosServicios')
                ->onDelete('cascade');
        });

        // Asegurar CASCADE DELETE en información
        Schema::table('tMarketComerciosServiciosInformacion', function (Blueprint $table) {
            // Primero eliminar la restricción existente si existe
            try {
                $table->dropForeign(['idMarketComerciosServicios']);
            } catch (Exception $e) {
                // Si no existe, continuar
            }

            // Crear nueva restricción con CASCADE DELETE
            $table->foreign('idMarketComerciosServicios')
                ->references('idMarketComerciosServicios')
                ->on('tMarketComerciosServicios')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios de estado a integers
        Schema::table('tMarketComerciosServicios', function (Blueprint $table) {
            $table->integer('estado')->default(1)->change();
        });

        Schema::table('tMarketComerciosServiciosInformacion', function (Blueprint $table) {
            $table->integer('estado')->default(1)->change();
        });

        // Convertir strings de vuelta a números
        DB::table('tMarketComerciosServicios')->update([
            'estado' => DB::raw("CASE 
                WHEN estado = 'eliminado' THEN 0
                WHEN estado = 'pendiente' THEN 1
                WHEN estado = 'aprobado' THEN 2
                WHEN estado = 'rechazado' THEN 3
                ELSE 1
            END")
        ]);

        DB::table('tMarketComerciosServiciosInformacion')->update([
            'estado' => DB::raw("CASE 
                WHEN estado = 'eliminado' THEN 0
                WHEN estado = 'pendiente' THEN 1
                WHEN estado = 'aprobado' THEN 2
                WHEN estado = 'rechazado' THEN 3
                ELSE 1
            END")
        ]);
    }
};