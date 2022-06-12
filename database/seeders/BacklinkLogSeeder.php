<?php

namespace Database\Seeders;

use App\Models\Backlink;
use App\Models\BacklinkLog;
use Illuminate\Database\Seeder;

class BacklinkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $backlink_logs = [];
        $backlinks = Backlink::all()->pluck('id');
        foreach ($backlinks as $backlink){
            for ($i = 1; $i <= 30; $i++) {
                array_push($backlink_logs, [
                    'backlink_id' => $backlink,
                    'data' => '',
                    'status' => 'ok',
                    'alt' => random_int(0, 1),
                    'anchor' => random_int(0, 1),
                    'noindex' => random_int(0, 1),
                    'nofollow' => random_int(0, 1),
                    'ugc' => random_int(0, 1),
                    'sponsored' => random_int(0, 1),
                    'is_lost' => random_int(0, 1),
                    'rank' => random_int(100, 1000),
                    'price' => random_int(100, 1000),
                    'spam_score' => 0,
                    'created_at' => date('Y-m-d H:i:s', strtotime('-' . $i . ' days'))
                ]);
            }
        }


        BacklinkLog::insert($backlink_logs);
    }
}
