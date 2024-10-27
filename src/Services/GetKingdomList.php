<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetKingdomList {
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getKingdomList() {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/taxa/kingdom/', [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $list = $response->toArray();

        if (!isset($list['kingdom_names'])) {
            return [];
        }

        $data = [];

        foreach($list['kingdom_names'] as $item) {
            $data[] = [
                'name' => $item,
            ];
        }

        return $data;
    }
}