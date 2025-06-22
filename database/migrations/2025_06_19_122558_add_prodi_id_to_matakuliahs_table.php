<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matakuliahs', function (Blueprint $table) {
            $table->foreignId('prodi_id')->after('sks')->nullable()->constrained('prodis')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('matakuliahs', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn('prodi_id');
        });
    }
};