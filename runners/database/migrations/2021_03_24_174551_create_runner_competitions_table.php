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
            $table->foreignId('runner_id')->constrained();
            $table->foreignId('competition_id')->constrained();
            $table->char('hour_end', 5)->nullable()->default(null);
            $table->integer('position')->nullable()->default(null);
            $table->primary(['runner_id', 'competition_id']);
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
