<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlinks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('domain_id')->nullable(false);
            $table->unsignedInteger('created_by')->nullable(false);
            $table->string('source', 255)->nullable(false);
            $table->string('dest', 255)->nullable(false);
            $table->boolean('alt');
            $table->boolean('anchor');
            $table->boolean('noindex');
            $table->boolean('nofollow');
            $table->boolean('ugc');
            $table->boolean('sponsored');
            $table->boolean('is_lost');
            $table->integer('rank');
            $table->integer('status_code');
            $table->dateTime('first_seen');
            $table->dateTime('last_seen');
            $table->timestamps();

            $table->index(['created_by', 'domain_id']);
            $table->index(['source', 'dest']);

            $table->foreign(['domain_id'])
                ->on('trx_domains')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreign(['created_by'])
                ->on('users')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backlinks');
    }
}
