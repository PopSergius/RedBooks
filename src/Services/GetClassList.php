<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Classes;

class GetClassList {
    private $httpClient;
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function getClassList() {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/taxa/class/', [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $list = $response->toArray();

        if (!isset($list['class_names'])) {
            return [];
        }

        $data = [];

        foreach($list['class_names'] as $item) {
//            $class = new Classes();
//            $class->setClassesName($item);
//            $class->setClassesCode($item);
//            $this->entityManager->persist($class);

            $data[] = [
                'name' => $item,
            ];
        }
//        $this->entityManager->flush();
        return $data;
    }
}