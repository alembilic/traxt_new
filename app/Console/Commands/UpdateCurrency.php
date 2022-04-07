<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Job to Update Currency';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = file_get_contents('http://www.nationalbanken.dk/_vti_bin/DN/DataService.svc/CurrencyRatesXML?lang=da');
        if ($data) {
            $xml = simplexml_load_string($data);
            foreach ($xml->dailyrates->currency as $rates) {
                if ((string)$rates['code'] === 'USD') {
                    $rate = str_replace(',', '.', (string)$rates['rate']);
                    Cache::put('currencyRate', $rate, 86400 * 2);
                }
            }
        }
        return 0;
    }
}
