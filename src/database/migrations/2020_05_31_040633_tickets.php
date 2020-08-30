<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function(BluePrint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parent_id');
            $table->string('text');
            $table->string('memo')->nullable(true);
            $table->dateTime('start_date_time');
            $table->dateTime('stop_date_time');
            $table->date('deadline_date');
            $table->integer('deadline_second')->comment("予定工数（秒）");
            $table->dateTime('run_start_date_time')->comment("開始ボタン押下日時");
            $table->dateTime('run_stop_date_time')->comment("停止ボタン押下日時");
            $table->integer('runtime_second')->comment('計測時間（秒）');
            $table->integer('status')->comment("ステータス　0:開始前, 1:計測中, 2:停止中, 3:完了, 99:削除");
            $table->integer('display_sequence');
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
        Schema::drop('tickets');
    }
}
