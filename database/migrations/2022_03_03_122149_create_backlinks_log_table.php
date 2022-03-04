<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBacklinksLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlinks_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('backlink_id')->nullable(false);
            $table->text('data')->default(null);
            $table->enum('status', ['ok', 'fail'])->default('ok')->nullable(false);
            $table->boolean('alt');
            $table->boolean('anchor');
            $table->boolean('noindex');
            $table->boolean('nofollow');
            $table->boolean('ugc');
            $table->boolean('sponsored');
            $table->boolean('is_lost');
            $table->integer('rank');
            $table->integer('status_code');
            $table->timestamps();

            $table->index(['backlink_id']);
            $table->index(['created_at']);
            $table->unique(['backlink_id', 'created_at']);

            $table->foreign(['backlink_id'])
                ->on('backlinks')
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
        Schema::dropIfExists('backlinks_log');
    }
}
