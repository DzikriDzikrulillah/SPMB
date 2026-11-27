<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jalur', function (Blueprint $table) {
            if (! Schema::hasColumn('jalur', 'kuota')) {
                $table->unsignedInteger('kuota')->default(0)->after('deskripsi_jalur');
            }
        });
    }

    public function down()
    {
        Schema::table('jalur', function (Blueprint $table) {
            if (Schema::hasColumn('jalur', 'kuota')) {
                $table->dropColumn('kuota');
            }
        });
    }
};
