<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Entities\ServiceInterest;

class CreateServiceInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_interests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('short_code', 30)->unique();
            $table->timestamps();
        });

        $this->seedData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_interests');
    }

    public function seedData()
    {
        $data = [
            ['name' => 'First Service', 'short_code' => '1st'],
            ['name' => 'Second Service', 'short_code' => '2nd']
        ];

        foreach ($data as $key => $item) {
            ServiceInterest::create([
                'name' => $item['name'],
                'short_code' => $item['short_code']
            ]);
        }
    }
}
