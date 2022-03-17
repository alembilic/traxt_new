<?php

use Illuminate\Database\Migrations\Migration;

class ConvertSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            INSERT IGNORE INTO subscriptions (
               next_due_date,
               cancel_date,
               payment_system,
               external_id,
               payment_url,
               accounting_system_id,
               payment_period,
               product_id,
               created_by,
               created_at,
               active
            )
            SELECT
                u.next_due_date as next_due_date,
                if (u.renew, null, if(u.next_due_date, u.next_due_date, CURRENT_DATE)) as cancel_date,
                'quickPay' as payment_system,
                o.subscription_id as external_id,
                o.payment_link as payment_url,
                u.dinero_add_guid as accounting_system_id,
                if (o.period = 2, 12, 1) as payment_period,
                p.id as product_id,
                u.id as created_by,
                o.created as created_at,
                1 as active
            FROM users u
                INNER JOIN products p ON u.plan=p.mix_id
                INNER JOIN (
                    SELECT MAX(so.id), o.user_id, o.created, o.amount, o.dinero_guid, so.payment_link, so.subscription_id,
                           SUBSTRING_INDEX(so.product_id, '-', -1) as period
                    FROM orders o
                    INNER JOIN subscriptions_orders so ON so.subscription_id = o.subscriptions_orders_id
                    GROUP BY o.user_id
                ) as o ON o.user_id=u.id
            WHERE o.subscription_id != ''
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('subscriptions')->truncate();
    }
}
