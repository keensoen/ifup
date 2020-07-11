<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25)->unique();
            $table->foreignId('salutation_id');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('surname', 50);
            $table->timestamp('birthday');
            $table->string('tel', 40)->unique();
            $table->string('email', 100)->unique();
            $table->text('address');
            $table->foreignId('serivice_interest_id');
            $table->enum('save_before', ['No', 'Yes', 'Not Sure'])->nullable();
            $table->enum('baptized', ['No', 'Yes'])->nullable();
            $table->enum('membership_interest', ['Yes', 'No'])->nullable();
            $table->enum('like_visited', ['Yes', 'No'])->nullable();
            $table->enum('workforce_interest', ['Yes', 'No'])->nullable();
            $table->string('availability', 30)->nullable();
            $table->foreignId('member_link')->nullable();
            $table->string('photo', 200)->nullable();
            $table->string('slug', 200);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
