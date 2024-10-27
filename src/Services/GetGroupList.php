<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Group;

class GetGroupList {
    private $httpClient;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function getGroupList() {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/comprehensive_groups/', [
            'headers' => [
                'accept' => '*/*',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $list = $response->toArray();

        if (!isset($list['comprehensive_group'])) {
            return [];
        }

        $data = [];

        foreach($list['comprehensive_group'] as $item) {
            $groupName = str_replace('_', ' ', $item['name']);

//            $group = new Group();
//            $group->setGroupCode($item['name']);
//            $group->setGroupName($groupName);
//
//            $this->entityManager->persist($group);

            $data[] = [
                'name' => $item['name'],
            ];
        }
//        $this->entityManager->flush();
        return $data;
    }

    public function getHeadersApi(string $name) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/comprehensive_groups/'. $name, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        return $response->getHeaders();
    }

    public function getObjectFromList(string $name, int $page) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/comprehensive_groups/'. $name . '?page=' . $page, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $data = $response->toArray();

        if (!isset($data['assessments'])) {
            return ['error'];
        }

        $list = [];

        foreach($data['assessments'] as $item) {
            $list[] = [
                'year_published' => $item['year_published'],
                'sis_taxon_id' =>$item['sis_taxon_id'],
                'url' => $item['url'],
                'assessment_id' => $item['assessment_id'],
            ];
        }

        return $list;
    }
}