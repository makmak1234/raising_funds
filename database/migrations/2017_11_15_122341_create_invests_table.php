<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->integer('amount_got');
            $table->integer('amount_type');
            $table->datetime('time_got');
            $table->string('label', 30);
            $table->string('full_answer', 2048);
            $table->integer('investors_id')->unsigned()->nullable();
            $table->foreign('investors_id')
              ->references('id')->on('investors')
              ->onDelete('cascade')->onEdit('cascade');
            $table->date('term');
            $table->enum('accept', ['0', '1', '2', '3']);
            // 0-не переводилось
            // 1-перевод успешный
            // 2-админ оплатил
            // 3-перевод сделан, ожидание зачисления
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
        Schema::dropIfExists('invests');
    }
}
