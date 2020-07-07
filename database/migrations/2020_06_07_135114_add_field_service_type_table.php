<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_interests', function (Blueprint $table) {
            $table->time('starts_at')->after('short_code')->nullable();
            $table->time('ends_at')->after('starts_at')->nullable();
            $table->integer('capacity')->after('ends_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_interests', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');
            $table->dropColumn('capacity');
        });
    }
}
