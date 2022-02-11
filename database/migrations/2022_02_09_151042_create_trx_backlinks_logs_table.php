<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxBacklinksLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_backlinks_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('domain_id')->nullable(false);
            $table->unsignedInteger('backlink_id')->nullable(false);
            $table->text('data')->default(null);
            $table->enum('status', ['ok', 'fail'])->default('ok')->nullable(false);
            $table->timestamps();

            $table->foreign(['domain_id'])
                ->on('trx_domains')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign(['backlink_id'])
                ->on('trx_backlinks')
                ->references('id')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->index(['domain_id', 'backlink_id']);
            $table->index(['created_at']);
            $table->unique(['domain_id', 'backlink_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_backlinks_logs');
    }
}
