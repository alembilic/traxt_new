<?php

namespace App\Services\UrlParsers;

use App\Dto\BackLinksRawData;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * DataForSEO service
 */
class DataForSeoService
{
    /**
     * @var ClientInterface|Client
     */
    protected ClientInterface $client;

    /**
     * @var string
     */
    protected string $baseUrl = 'https://api.dataforseo.com/v3/backlinks';

    /**
     * @param ClientInterface|Client $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of backlinks.
     *
     * @param string $path target path
     *
     * @return Collection<BackLinksRawData>
     *
     * @throws GuzzleException
     */
    public function getBackLinksByPath(string $path): Collection
    {
        $result = Cache::get($path);
        if (!$result) {
            $data = json_encode([
                [
                    'target' => $path,
                    'mode' => 'as_is',
                    'limit' => 200,
                ]
            ]);
            $request = new Request(
                'POST',
                $this->baseUrl . '/backlinks/live',
                $this->getAuthHeaders(),
                $data
            );

            $result = (string)$this->client->send($request)->getBody();
            if ($result) {
                Cache::put($path, $result, 3600);
            }
        }
        if (!$result) {
            return collect();
        }

        $data = json_decode($result, true);
        if (!count($data['tasks'])) {
            return collect();
        }

        $items = [];
        foreach ($data['tasks'] as $task) {
            foreach($task['result'] as $result) {
                $items = array_merge($items, $result['items']);
            }
        }

        return collect($items)->map(function (array $item) {
            return new BackLinksRawData([
                BackLinksRawData::DOMAIN_NAME => $item['domain_from'],
                BackLinksRawData::SOURCE_URL => $item['url_from'],
                BackLinksRawData::TLD_NAME => $item['domain_to'],
                BackLinksRawData::TLD_LINK => $item['domain_from'],
                BackLinksRawData::DEST_URL => $item['url_to'],
                BackLinksRawData::FIRST_FOUND => Carbon::parse($item['first_seen']),
                BackLinksRawData::LAST_FOUND => Carbon::parse($item['last_seen']),
                BackLinksRawData::LAST_CHECKED => Carbon::now(),
                BackLinksRawData::HEAD_NOFOLLOW => !$item['dofollow'],
                BackLinksRawData::IMG_TEXT => $item['alt'],
                BackLinksRawData::ANCHOR_TEXT => $item['anchor'],
                BackLinksRawData::RESPONSE => $item['url_to_status_code'],
                BackLinksRawData::LINK_TYPE => 1,
                BackLinksRawData::REL_NOFOLLOW => $item['attributes'] === 'nofollow',
                BackLinksRawData::REL_NOINDEX => $item['attributes'] === 'noindex',
                BackLinksRawData::REL_UGC => $item['attributes'] === 'ugc',
                BackLinksRawData::REL_SPONSORED => $item['attributes'] === 'sponsored',
                BackLinksRawData::RANK => (int)$item['rank'],
                BackLinksRawData::IS_LOST => (bool)$item['is_lost'],
            ]);
        });
    }

    /**
     * Authorization.
     * Instead of 'login' and 'password' use your credentials from https://app.dataforseo.com/api-dashboard
     *
     * @return string[]
     */
    private function getAuthHeaders(): array
    {
        $authString = base64_encode(config('services.dfs.login') . ':' . config('services.dfs.password'));
        return [
            'Authorization: Basic ' . $authString,
            'Content-Type: application/json',
        ];
    }
}
