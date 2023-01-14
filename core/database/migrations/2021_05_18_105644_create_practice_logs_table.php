<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('coin_id');
            $table->decimal('amount', 18, 8)->default(0);
            $table->decimal('price_was', 18, 8)->default(0);
            $table->string('duration', 191);
            $table->string('time_unit', 191);
            $table->tinyInteger('hilow')->default(0)->comment('High : 1 Low : 2');
            $table->tinyInteger('result')->default(0)->comment('win : 1 lose : 2 Draw : 3');
            $table->tinyInteger('status')->default(0)->comment('Running : 0 Complete : 1');
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
        Schema::dropIfExists('practice_logs');
    }
}
