<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('dates');
            $table->string('dates_array');
            $table->string('place');
            $table->string('image')->default("0");
            $table->string('special_guests')->default("nothing");
            $table->string('step');
            $table->string('tarifs');
            $table->string('coach_price');
        });

        DB::table('settings')->insert(
            array(
                'name' => 'name',
                'dates' => 'dates',
                'place' => 'place',
                'dates_array' => 'dates_array',
                'special_guests' => 'special_guests',
                'step' => '1',
                'tarifs' => 'tarifs_name',
                'coach_price' => '0'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
