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
        Schema::create('tMarketComerciosServiciosContactosMultiples', function (Blueprint $table) {
            $table->id('idContactoMultiple');
            $table->integer('idMarketComerciosServicios');
            $table->enum('tipo', [
                'telefono', 'whatsapp', 'correo', 'sitioWeb',
                'facebook', 'instagram', 'tiktok', 'twitter',
                'linkedin', 'youtube', 'telegram', 'pinterest', 'snapchat'
            ]);
            $table->string('valor', 255);
            $table->integer('orden')->default(1);
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Índices
            $table->index(['idMarketComerciosServicios', 'tipo', 'activo']);
            $table->index(['idMarketComerciosServicios', 'orden']);

            // Clave foránea con CASCADE DELETE
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
        Schema::dropIfExists('tMarketComerciosServiciosContactosMultiples');
    }
};