<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Entities\Salutation;

class CreateSalutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salutations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->unique();
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
        Schema::dropIfExists('salutations');
    }

    public function seedData()
    {
        $data = [
            ['title' => 'Mister', 'short_code' => 'Mr.'],
            ['title' => 'Misses', 'short_code' => 'Mrs.'],
            ['title' => 'Master', 'short_code' => 'Ms.'],
            ['title' => 'Miss', 'short_code' => 'Miss.'],
            ['title' => 'Brother', 'short_code' => 'Bro.'],
            ['title' => 'Sister', 'short_code' => 'Sis.'],
            ['title' => 'Pastor', 'short_code' => 'Pst.'],
            ['title' => 'Pastor Misses', 'short_code' => 'Pst. Mrs.'],
            ['title' => 'Chief', 'short_code' => 'Chief'],
            ['title' => 'Bishop', 'short_code' => 'Bishop.']
        ];

        foreach ($data as $key => $item) {
            Salutation::create([
                'title' => $item['title'],
                'short_code' => $item['short_code']
            ]);
        }
    }
}
