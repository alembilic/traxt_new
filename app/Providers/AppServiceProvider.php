<?php

namespace App\Providers;

use App\Core\ChannelManager;
use App\Core\Mail\MailChannel;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Mail\Factory;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\ChannelManager as BaseChannelManager;
use Illuminate\Notifications\Channels\MailChannel as BaseMailChannel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Dispatcher::class, function (Application $app) {
            return new ChannelManager($app);
        });
        $this->app->singleton(BaseChannelManager::class, function (Application $app) {
            return new ChannelManager($app);
        });

        $this->app->singleton(BaseMailChannel::class, function (Application $app) {
            return new MailChannel($app->make(Factory::class), $app->make(Markdown::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }

        $this->app->bind(ClientInterface::class, GuzzleClient::class);

        if ($this->app->environment('local')) {
            $mock = new MockHandler([
                new Response(200, ['Content-Type' => 'application/json'], '{
      "version": "0.1.20210907",
      "status_code": 20000,
      "status_message": "Ok.",
      "time": "10.7121 sec.",
      "cost": 0.02015,
      "tasks_count": 1,
      "tasks_error": 0,
      "tasks": [
        {
          "id": "09101550-1535-0269-0000-fffdc584aa01",
          "status_code": 20000,
          "status_message": "Ok.",
          "time": "10.6528 sec.",
          "cost": 0.02015,
          "result_count": 1,
          "path": [
            "v3",
            "backlinks",
            "backlinks",
            "live"
          ],
          "data": {
            "api": "backlinks",
            "function": "backlinks",
            "target": "forbes.com",
            "mode": "as_is",
            "filters": [
              "dofollow",
              "=",
              true
            ],
            "limit": 5
          },
          "result": [
            {
              "target": "forbes.com",
              "mode": "as_is",
              "total_count": 10292401,
              "items_count": 5,
              "items": [
                {
                  "type": "backlink",
                  "domain_from": "bit.ly",
                  "url_from": "http://bit.ly/2Y2rVX8",
                  "url_from_https": false,
                  "domain_to": "www.forbes.com",
                  "url_to": "https://www.forbes.com/sites/cryptoconfidential",
                  "url_to_https": true,
                  "tld_from": "ly",
                  "is_new": false,
                  "is_lost": false,
                  "rank": 674,
                  "page_from_rank": 685,
                  "domain_from_rank": 754,
                  "domain_from_platform_type": null,
                  "domain_from_is_ip": false,
                  "domain_from_ip": "67.199.248.11",
                  "page_from_external_links": 0,
                  "page_from_internal_links": 0,
                  "page_from_size": 134,
                  "page_from_encoding": null,
                  "page_from_language": null,
                  "page_from_title": null,
                  "page_from_status_code": 301,
                  "first_seen": "2019-08-24 09:17:54 +00:00",
                  "prev_seen": "2021-08-26 12:58:13 +00:00",
                  "last_seen": "2021-09-05 12:59:29 +00:00",
                  "item_type": "redirect",
                  "attributes": null,
                  "dofollow": false,
                  "original": false,
                  "alt": null,
                  "anchor": null,
                  "text_pre": null,
                  "text_post": null,
                  "semantic_location": null,
                  "links_count": 1,
                  "group_count": 0,
                  "is_broken": false,
                  "url_to_status_code": 302
                },
                {
                  "type": "backlink",
                  "domain_from": "bit.ly",
                  "url_from": "https://bit.ly/2Rkd9oN",
                  "url_from_https": true,
                  "domain_to": "cloud.read.forbes.com",
                  "url_to": "https://cloud.read.forbes.com/Investing-Digest-Sign-Up?k=FDC_INV_Opt",
                  "url_to_https": true,
                  "tld_from": "ly",
                  "is_new": false,
                  "is_lost": false,
                  "rank": 656,
                  "page_from_rank": 667,
                  "domain_from_rank": 754,
                  "domain_from_platform_type": null,
                  "domain_from_is_ip": false,
                  "domain_from_ip": "67.199.248.11",
                  "page_from_external_links": 0,
                  "page_from_internal_links": 0,
                  "page_from_size": 155,
                  "page_from_encoding": null,
                  "page_from_language": null,
                  "page_from_title": null,
                  "page_from_status_code": 301,
                  "first_seen": "2020-10-30 22:42:03 +00:00",
                  "prev_seen": "2021-08-26 13:42:58 +00:00",
                  "last_seen": "2021-09-05 13:44:44 +00:00",
                  "item_type": "redirect",
                  "attributes": null,
                  "dofollow": true,
                  "original": false,
                  "alt": null,
                  "anchor": null,
                  "text_pre": null,
                  "text_post": null,
                  "semantic_location": null,
                  "links_count": 1,
                  "group_count": 0,
                  "is_broken": false,
                  "url_to_status_code": 200
                },
                {
                  "type": "backlink",
                  "domain_from": "bit.ly",
                  "url_from": "http://bit.ly/2YWucPR",
                  "url_from_https": false,
                  "domain_to": "info.forbes.com",
                  "url_to": "http://info.forbes.com/CM_EM_ID_Signup_Dropdown_Investing-Digest-Sign-Up.html?k=EM_ID_Dropdown",
                  "url_to_https": false,
                  "tld_from": "ly",
                  "is_new": true,
                  "is_lost": false,
                  "rank": 652,
                  "page_from_rank": 664,
                  "domain_from_rank": 725,
                  "domain_from_platform_type": null,
                  "domain_from_is_ip": false,
                  "domain_from_ip": "67.199.248.11",
                  "page_from_external_links": 0,
                  "page_from_internal_links": 0,
                  "page_from_size": 181,
                  "page_from_encoding": null,
                  "page_from_language": null,
                  "page_from_title": null,
                  "page_from_status_code": 301,
                  "first_seen": "2020-08-15 21:24:18 +00:00",
                  "prev_seen": null,
                  "last_seen": "2020-08-15 21:24:18 +00:00",
                  "item_type": "redirect",
                  "attributes": null,
                  "dofollow": true,
                  "original": true,
                  "alt": null,
                  "anchor": null,
                  "text_pre": null,
                  "text_post": null,
                  "semantic_location": null,
                  "links_count": 1,
                  "group_count": 0,
                  "is_broken": true,
                  "url_to_status_code": 404
                },
                {
                  "type": "backlink",
                  "domain_from": "www.opencart.com",
                  "url_from": "https://www.opencart.com/",
                  "url_from_https": true,
                  "domain_to": "www.forbes.com",
                  "url_to": "http://www.forbes.com/sites/brentgleeson/2014/09/05/3-steps-to-launch-your-first-ecommerce-website/",
                  "url_to_https": false,
                  "tld_from": "com",
                  "is_new": false,
                  "is_lost": false,
                  "rank": 640,
                  "page_from_rank": 821,
                  "domain_from_rank": 656,
                  "domain_from_platform_type": [
                    "unknown"
                  ],
                  "domain_from_is_ip": false,
                  "domain_from_ip": "104.20.15.19",
                  "page_from_external_links": 19,
                  "page_from_internal_links": 16,
                  "page_from_size": 18564,
                  "page_from_encoding": "utf-8",
                  "page_from_language": "en",
                  "page_from_title": "OpenCart - Open Source Shopping Cart Solution",
                  "page_from_status_code": 200,
                  "first_seen": "2019-01-21 18:17:01 +00:00",
                  "prev_seen": "2021-07-27 08:48:37 +00:00",
                  "last_seen": "2021-08-06 17:24:17 +00:00",
                  "item_type": "anchor",
                  "attributes": null,
                  "dofollow": true,
                  "original": false,
                  "alt": "Forbes",
                  "anchor": null,
                  "text_pre": null,
                  "text_post": null,
                  "semantic_location": null,
                  "links_count": 1,
                  "group_count": 0,
                  "is_broken": false,
                  "url_to_status_code": 301
                },
                {
                  "type": "backlink",
                  "domain_from": "www.yola.com",
                  "url_from": "https://www.yola.com/",
                  "url_from_https": true,
                  "domain_to": "www.forbes.com",
                  "url_to": "http://www.forbes.com/sites/mfonobongnsehe/2012/02/13/top-20-tech-startups-in-africa/",
                  "url_to_https": false,
                  "tld_from": "com",
                  "is_new": false,
                  "is_lost": false,
                  "rank": 593,
                  "page_from_rank": 739,
                  "domain_from_rank": 562,
                  "domain_from_platform_type": [
                    "unknown"
                  ],
                  "domain_from_is_ip": false,
                  "domain_from_ip": "104.18.126.89",
                  "page_from_external_links": 9,
                  "page_from_internal_links": 23,
                  "page_from_size": 40585,
                  "page_from_encoding": "utf-8",
                  "page_from_language": "en",
                  "page_from_title": "Yola - Make a Free Website",
                  "page_from_status_code": 200,
                  "first_seen": "2021-07-25 21:13:28 +00:00",
                  "prev_seen": "2021-08-26 18:45:45 +00:00",
                  "last_seen": "2021-09-06 01:20:18 +00:00",
                  "item_type": "anchor",
                  "attributes": null,
                  "dofollow": true,
                  "original": false,
                  "alt": "Forbes",
                  "anchor": null,
                  "text_pre": null,
                  "text_post": null,
                  "semantic_location": "section",
                  "links_count": 1,
                  "group_count": 0,
                  "is_broken": false,
                  "url_to_status_code": 301
                }
              ]
            }
          ]
        }
      ]
    }'),
            ]);
            $handlerStack = HandlerStack::create($mock);
            $this->app->instance('GuzzleHttp\Client', new GuzzleClient(['handler' => $handlerStack]));
        }
    }
}
