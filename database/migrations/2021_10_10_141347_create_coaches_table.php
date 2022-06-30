<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('program');
            $table->string('currency');
            $table->integer('price');
            $table->integer('working_hours');
            $table->integer('available_hours');
            $table->integer('taked_hours')->default(0);
            $table->text('regalia')->nullable();
            $table->string('comments')->nullable();
            $table->boolean('checked')->default(false);
            $table->boolean('closed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coaches');
    }
}
