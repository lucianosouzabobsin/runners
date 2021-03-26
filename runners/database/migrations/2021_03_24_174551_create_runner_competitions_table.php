<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunnerCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runner_competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('runner_id')->constrained();
            $table->foreignId('competition_id')->constrained();
            $table->integer('runner_age');
            $table->char('hour_end', 8);
            $table->char('trial_time', 8);
            $table->integer('position_competition')->default('0');
            $table->integer('position_range_age')->default('0');
            $table->integer('position_range_age_type')->default('0');
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
        Schema::dropIfExists('runner_competitions');
    }
}
