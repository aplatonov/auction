<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lot_name', 200)->unique();
            $table->text('description');
            $table->string('images', 250)->nullable();
            $table->integer('category_id')->unsigned();
            $table->float('start_price', 10,2);
            $table->integer('owner_id')->unsigned();
            $table->datetime('begin_auction');
            $table->datetime('end_auction');
            $table->integer('disable_reason_id')->unsigned()->nullable();
            $table->boolean('disabled')->default(false);
            $table->datetime('disabled_date')->nullable();
            $table->float('final_price', 10,2)->nullable();
            $table->integer('pay_status_id')->unsigned()->nullable();
            $table->integer('winner_id')->unsigned()->nullable();
            $table->timestamps();
        });



        Schema::table('lots', function (Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('pay_status_id')->references('id')->on('pay_status')
                        ->onDelete('restrict')
                        ->onUpdate('cascade');
            $table->foreign('winner_id')->references('id')->on('users')
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
        Schema::table('lots', function (Blueprint $table) {
            $table->dropForeign('lots_owner_id_foreign');
            $table->dropForeign('lots_category_id_foreign');
            $table->dropForeign('lots_pay_status_id_foreign');
            $table->dropForeign('lots_winner_id_foreign');
        });

        Schema::drop('lots');
    }
}
