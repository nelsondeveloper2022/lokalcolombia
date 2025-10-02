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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('market_commerce_service_id')->nullable()->after('email_verified_at');
            $table->foreign('market_commerce_service_id')->references('idMarketComerciosServicios')->on('tMarketComerciosServicios')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['market_commerce_service_id']);
            $table->dropColumn('market_commerce_service_id');
        });
    }
};
