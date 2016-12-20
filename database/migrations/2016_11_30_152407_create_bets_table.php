<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lot_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('bet_price', 10,2);
            $table->boolean('is_final')->default(false);
            $table->timestamps();
        });



        Schema::table('bets', function (Blueprint $table) {
            $table->foreign('lot_id')->references('id')->on('lots')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');

        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bets', function (Blueprint $table) {
            $table->dropForeign('bets_lot_id_foreign');
            $table->dropForeign('bets_user_id_foreign');
        });

        Schema::drop('bets');
    }
}
