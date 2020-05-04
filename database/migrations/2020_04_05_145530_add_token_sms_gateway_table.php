<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenSmsGatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_gateways', function (Blueprint $table) {
            $table->string('token', 150)->after('url')->nullable();
            $table->char('routing', 2)->after('token')->nullable();
            $table->char('type', 2)->after('routing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_gateways', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}
