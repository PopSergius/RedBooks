<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetActionList {
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getActionList() {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/conservation_actions/', [
            'headers' => [
                'accept' => '*/*',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $list = $response->toArray();

        if (!isset($list['conservation_actions'])) {
            return [];
        }

        $data = [];

        foreach($list['conservation_actions'] as $item) {
            $data[] = [
                'description' => $item['description']['en'],
                'code' => $item['code'],
            ];
        }

        return $data;
    }
}