<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Services\GetAnimalData;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class GetRedListCategories {

    private $httpClient;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function getCategoreisList() : array{
        $data =[];
        $categoryRepository = $this->entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        $data[] = [
            'Category_code' => NULL,
            'Category_name' => "-any-",
        ];
        foreach ($categories as $category) {
            $data[] = [
                'Category_code' => $category->getCategoryCode(),
                'Category_name' => $category->getCategoryName(),
            ];
        }

        return $data;
    }

    public function getAnimalFromCategoreis(string $code) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/red_list_categories/' . $code . '?latest=true', [
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
            $pageResponse= $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/red_list_categories/' . $code .'?page=' . $i . '&latest=true', [
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