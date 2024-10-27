<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Country;

class GetCountryList {
    private $httpClient;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function getCountryList() {
        $data =[];
        $categoryRepository = $this->entityManager->getRepository(Country::class);
        $categories = $categoryRepository->findAll();
        $data[] = [
            'Country_code' => NULL,
            'Country_name' => "-any-",
        ];
        foreach ($categories as $category) {
            $data[] = [
                'Country_code' => $category->getCountryCode(),
                'Country_name' => $category->getCountryName(),
            ];
        }

        return $data;
    }

    public function getAnimalsFromCountry(string $code) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/countries/' . $code . '?latest=true', [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $headers = $response->getHeaders();
        var_dump($headers['total-pages']);
        $countPages = 0;

        if($headers['total-pages'] > 100) {
            $countPages = 100;
        } else {
            $countPages = $headers['total-pages'];
        }

        $list = [];

        for ($i = 1; $i <= $countPages; $i++) {
            $pageResponse= $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/countries/' . $code .'?page=' . $i . '&latest=true', [
                'headers' => [
                    'accept' => 'application/json',
                    'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
                ],
            ]);

            $pageData = $pageResponse->toArray();
            foreach($pageData['assessments'] as $item){
                $list[] = [
                    'assessment_id' => $item['assessment_id'],
                ];
            }
        }

        return $list;
    }
}