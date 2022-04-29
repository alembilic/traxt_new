<?php

namespace App\Services\UrlParsers;

use App\Dto\BackLinks\BackLinksRawData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * DataForSEO service
 */
class DataForSeoService
{
    /**
     * @var string
     */
    protected string $baseUrl = 'https://api.dataforseo.com/v3';
    protected int $recursionLimit = 0;
    protected bool $followNextPage = false;

    /**
     * Returns a list of backlinks.
     *
     * @param string $path target path
     * @param string|null $search search
     *
     * @return Collection<BackLinksRawData>
     */
    public function getBackLinksByPath(string $path, ?string $search = null): Collection
    {
        $filter = [
            'target' => $path,
            'mode' => 'as_is',
            'limit' => 1000,
            'backlinks_status_type' => 'all',
            'include_subdomains' => false,
        ];
        if ($search) {
            $filter['filters'] = [
                ['url_from','like',"%$search%"],'or',['url_to','like',"%$search%"]
            ];
        }

        $items = collect($this->makeRequest($filter));

        return $items->map(function (array $item) {
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
                BackLinksRawData::SPAM_SCORE => (int)$item['backlink_spam_score'],
            ]);
        });
    }

    private function makeRequest(array $filter, array $items = [], $nextPageToken = null): array
    {
        if ($this->recursionLimit++ > 200) {
            return $items;
        }
        if ($nextPageToken) {
            $filter['search_after_token'] = $nextPageToken;
        } else {
            unset($filter['search_after_token']);
        }

        $cacheKey = sha1(json_encode($filter));
        $result = Cache::get($cacheKey);
        if (!$result) {
            $data = json_encode([$filter]);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->baseUrl . '/backlinks/backlinks/live',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => $this->getAuthHeaders(),
            ));

            $result = curl_exec($curl);
            $responseData = curl_getinfo($curl);
            curl_close($curl);

            if ($responseData['http_code'] === 200) {
                Cache::put($cacheKey, $result, 3600);
            }
        }
        if (!$result) {
            return $items;
        }

        $data = json_decode($result, true);
        if (!count($data['tasks'])) {
            return $items;
        }

        foreach ($data['tasks'] as $task) {
            foreach($task['result'] as $result) {
                $itemsMap = array_map(function (array $item) {
                    return [
                        'domain_from' => $item['domain_from'],
                        'url_from' => $item['url_from'],
                        'domain_to' => $item['domain_to'],
                        'url_to' => $item['url_to'],
                        'first_seen' => $item['first_seen'],
                        'last_seen' => $item['last_seen'],
                        'dofollow' => $item['dofollow'],
                        'alt' => $item['alt'],
                        'anchor' => $item['anchor'],
                        'url_to_status_code' => $item['url_to_status_code'],
                        'attributes' => $item['attributes'],
                        'rank' => $item['rank'],
                        'is_lost' => $item['is_lost'],
                        'backlink_spam_score' => $item['backlink_spam_score'],
                    ];
                }, $result['items']);
                $items = array_merge($items, $itemsMap);
                if (
                    $this->followNextPage &&
                    count($result['items']) &&
                    $result['search_after_token'] &&
                    $result['total_count'] != count($result['items'])
                ) {
                    $items = $this->makeRequest($filter, $items, $result['search_after_token']);
                }
            }
        }

        return $items;
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

    public function followNextPage(bool $follow): void
    {
        $this->followNextPage = $follow;
    }
}
