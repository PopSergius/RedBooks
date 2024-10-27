<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAnimalData {
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAnimalName(int $animal_id) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/assessment/' . $animal_id, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $data = $response->toArray();

        if (!isset($data['taxon'])) {
            return [];
        }

        return $data['taxon']['scientific_name'];
    }

    public function getAnimalTeaserData(int $animal_id) {
        $response = $this->httpClient->request('GET', 'https://api.iucnredlist.org/api/v4/assessment/' . $animal_id, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
            ],
        ]);

        $data = $response->toArray();

        if (!isset($data['taxon'])) {
            return [];
        }

        $locations = $data['locations'];
        $resultlocation = [];
        
        foreach ($locations as $location) {
            if (isset($location['description']['en'])) {
                $resultlocation[] = $location['description']['en'];
                if (count($resultlocation) === 5) {
                    break;
                }
            }
        }

        $animalData = [
            'assessment_id' => $data['assessment_id'],
            'year_published' => $data['year_published'],
            'date_published' => $data['assessment_date'],
            'animal_name' => $data['taxon']['scientific_name'],
            'red_list_category' => $data['red_list_category']['description']['en'],
            'locations' => $resultlocation,
        ];

        return $animalData;
    }
}