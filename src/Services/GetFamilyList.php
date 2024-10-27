<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Family;

class GetFamilyList
{
    private $httpClient;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function getFamilyList() {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/taxa/family/', [
            'headers' => [
                'accept: application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $list = $response->toArray();

        if (!isset($list['family_names'])) {
            return [];
        }

        $data = [];

        foreach($list['family_names'] as $item) {
            $familyName = str_replace('_', ' ', $item);
//
//            $family = new Family();
//            $family->setFamilyCode($item);
//            $family->setFamilyName($familyName);
//
//            $this->entityManager->persist($family);

            $data[] = [
                'name' => $item,
            ];
        }
//        $this->entityManager->flush();
        return $data;
    }
}