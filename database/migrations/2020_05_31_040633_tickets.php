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
            $table->string('memo');
            $table->date('start_date');
            $table->date('stop_date');
            $table->date('deadline_date');
            $table->integer('status');
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
