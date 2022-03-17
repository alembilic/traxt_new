<?php

use Illuminate\Database\Migrations\Migration;

class ConvertSubscriptionsCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement("
            INSERT INTO subscriptions_charges (
                subscriptions_id,
                created_by,
                amount,
                vat,
                accounting_system_id,
                created_at
            )
            SELECT
                s.id as subscriptions_id,
                s.created_by,
                o.amount as amount,
                o.vat as vat,
                o.dinero_guid as accounting_system_id,
                s.created_at
            FROM subscriptions s
            INNER JOIN orders o ON o.subscriptions_orders_id = s.external_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('subscriptions_change')->truncate();
    }
}
