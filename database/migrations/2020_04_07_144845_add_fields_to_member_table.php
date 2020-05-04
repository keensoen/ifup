<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('first_time_visitor')->default(false)->after('baptized');
            $table->boolean('returning_visitor')->default(false)->after('first_time_visitor');
            $table->boolean('new_resident')->default(false)->after('returning_visitor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('first_time_visitor');
            $table->dropColumn('returning_visitor');
            $table->dropColumn('new_resident');
        });
    }
}
