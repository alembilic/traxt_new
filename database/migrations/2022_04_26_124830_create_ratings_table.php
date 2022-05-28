<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('contact_id')->nullable(false);
            $table->integer('value')->nullable(false);
            $table->string('comment', 500)->nullable(true);
            $table->foreign(['user_id'])
            ->on('users')
            ->references('id')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
            $table->foreign(['contact_id'])
            ->on('contacts')
            ->references('id')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');               
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
        Schema::dropIfExists('ratings');
    }
}
