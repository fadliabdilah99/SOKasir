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
        Schema::table('sos', function (Blueprint $table) {
            $table->string('kode')->after('id');
            $table->integer('hargamodal')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sos', function (Blueprint $table) {
            $table->dropColumn('kode');
            $table->dropColumn('hargamodal');
        });
    }
};
