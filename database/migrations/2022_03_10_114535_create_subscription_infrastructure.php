<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionInfrastructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->date('next_due_date')->nullable(false);
            $table->date('cancel_date')->nullable();
            $table->boolean('active')->nullable(false)->default(false);
            $table->string('payment_system', 50)->nullable(false)->default('quickPay');
            $table->string('external_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('accounting_system_id')->nullable();
            $table->unsignedInteger('payment_period')->nullable();
            $table->unsignedInteger('product_id')->nullable(false);
            $table->unsignedInteger('created_by')->nullable(false);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['created_by']);
            $table->index(['next_due_date']);
            $table->index(['created_at']);
        });

        Schema::create('subscriptions_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscriptions_id')->nullable(false);
            $table->unsignedInteger('created_by')->nullable(false);
            $table->unsignedInteger('amount')->nullable(false)->default(0);
            $table->unsignedInteger('vat')->nullable(false)->default(0);
            $table->string('accounting_system_id')->nullable();
            $table->string('external_id')->nullable();
            $table->enum('status', ['pending', 'fail', 'complete'])->nullable(false)->default('pending');
            $table->timestamps();

            $table->index(['subscriptions_id']);
            $table->index(['created_at']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscriptions_charges');
    }
}
