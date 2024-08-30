<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'canceled', 'denied'])
                ->default('pending')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
        //
    });
    }
};

