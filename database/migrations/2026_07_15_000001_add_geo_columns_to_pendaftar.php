<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('pendaftar', function (Blueprint $table) {
      if (! Schema::hasColumn('pendaftar', 'latitude')) {
        $table->decimal('latitude', 10, 8)->nullable()->after('sktm');
      }
      if (! Schema::hasColumn('pendaftar', 'longitude')) {
        $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
      }
      if (! Schema::hasColumn('pendaftar', 'jarak_km')) {
        $table->decimal('jarak_km', 8, 2)->nullable()->after('longitude');
      }
    });
  }

  public function down(): void
  {
    Schema::table('pendaftar', function (Blueprint $table) {
      if (Schema::hasColumn('pendaftar', 'jarak_km')) {
        $table->dropColumn('jarak_km');
      }
      if (Schema::hasColumn('pendaftar', 'longitude')) {
        $table->dropColumn('longitude');
      }
      if (Schema::hasColumn('pendaftar', 'latitude')) {
        $table->dropColumn('latitude');
      }
    });
  }
};
