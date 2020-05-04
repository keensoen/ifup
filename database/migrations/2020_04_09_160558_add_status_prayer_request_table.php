<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPrayerRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prayer_requests', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('prayer_point');
            $table->boolean('attended_to?')->default(false)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prayer_requests', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('attended_to?');
        });
    }
}
