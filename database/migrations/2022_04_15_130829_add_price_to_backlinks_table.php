<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToBacklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backlinks', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable()->after('status_code');
            $table->unsignedInteger('spam_score')->nullable(false)->default(0)->after('price');
        });
        Schema::table('backlinks_log', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable()->after('status_code');
            $table->unsignedInteger('spam_score')->nullable(false)->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backlinks', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('spam_score');
        });
        Schema::table('backlinks_log', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('spam_score');
        });
    }
}
