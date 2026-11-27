<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('pendaftar', function (Blueprint $table) {
      if (! Schema::hasColumn('pendaftar', 'sktm')) {
        $table->string('sktm')->nullable()->after('kartu_keluarga');
      }
      if (! Schema::hasColumn('pendaftar', 'origin_lat')) {
        $table->decimal('origin_lat', 10, 7)->nullable()->after('sktm');
      }
      if (! Schema::hasColumn('pendaftar', 'origin_lng')) {
        $table->decimal('origin_lng', 10, 7)->nullable()->after('origin_lat');
      }
    });
  }

  public function down(): void
  {
    Schema::table('pendaftar', function (Blueprint $table) {
      if (Schema::hasColumn('pendaftar', 'origin_lng')) {
        $table->dropColumn('origin_lng');
      }
      if (Schema::hasColumn('pendaftar', 'origin_lat')) {
        $table->dropColumn('origin_lat');
      }
      if (Schema::hasColumn('pendaftar', 'sktm')) {
        $table->dropColumn('sktm');
      }
    });
  }
};
