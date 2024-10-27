<?php
namespace App\Controller;

use App\Entity\EntityObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainPageController extends AbstractController
{
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): Response
    {
        $animals= $this->getAnimals(14);

        return $this->render('homepage-body.html.twig',[
            'pageTitle' => "Red Book",
            'animals' => $animals,
        ]);
    }

    private function getAnimals($count = 10) {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('eo, k, cl, f, cat, co')
            ->from(EntityObject::class, 'eo')
            ->leftJoin('eo.Kingdom', 'k')
            ->leftJoin('eo.Classes', 'cl')
            ->leftJoin('eo.Family', 'f')
            ->leftJoin('eo.Category', 'cat')
            ->leftJoin('eo.Countries', 'co')
            ->where('eo.ImageSrc != :imageSrc')
            ->setParameter('imageSrc', '')
            ->orderBy('eo.id', 'DESC')
            ->setMaxResults($count);

        return $qb->getQuery()->getResult();
    }

    public function second(): Response {
        set_time_limit(0);
        $listCountries = $this->getCountryList->getCountryList();
//
//        foreach ($listCountries as $country) {
//            for ($indexPage = 1; $indexPage < 5; $indexPage++) {
//                $response = $this->httpClient->request('GET', "https://api.iucnredlist.org/api/v4/countries/{$country['code']}?page={$indexPage}&latest=true", [
//                    'headers' => [
//                        'accept' => '*/*',
//                        'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
//                    ],
//                ]);
//
//                $data = $response->toarray();
//
//                if (isset($data['assessments'])) {
//                    $listData = $data['assessments'];
//
//                    foreach ($listData as $item) {
//                        $responseItem = $this->httpClient->request('GET', "https://api.iucnredlist.org/api/v4/assessment/{$item['assessment_id']}", [
//                            'headers' => [
//                                'accept' => '*/*',
//                                'Authorization' => 'iNi5bMU238asQrevU6RbGgz9KNoygdo64bws',
//                            ],
//                        ]);
//
//                        $itemData = $responseItem->toArray();
//
//                        $entityObject = new EntityObject();
//
//                        $entityObject->setName($itemData['taxon']['scientific_name']);
//
//                        // Заповнюємо зв'язки з іншими сутностями
//                        $kingdom = $this->entityManager->getRepository(Kingdom::class)->findOneBy(['Kingdom_code' => $itemData['taxon']['kingdom_name']]);
//                        $classes = $this->entityManager->getRepository(Classes::class)->findOneBy(['Classes_code' => $itemData['taxon']['class_name']]);
//                        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['Category_code' => $itemData['red_list_category']['code']]);
//                        $family = $this->entityManager->getRepository(Family::class)->findOneBy(['Family_code' => $itemData['taxon']['family_name']]);
//
//                        $entityObject->setKingdom($kingdom);
//                        $entityObject->setClasses($classes);
//                        $entityObject->setCategory($category);
//                        $entityObject->setFamily($family);
//                        $entityObject->setRange($itemData['documentation']['range']);
//                        $entityObject->setPopulation($itemData['documentation']['population']);
//                        $entityObject->setHabitats($itemData['documentation']['habitats']);
//                        $entityObject->setThreats($itemData['documentation']['threats']);
//
//                        $countryEntity = $this->entityManager->getRepository(Country::class)->findOneBy(['Country_code' => $country['code']]);
//                        $entityObject->addCountry($countryEntity);
//
//
//
//                        // Search Image
//                        $responseGBIF = $this->httpClient->request('GET', "https://api.gbif.org/v1/species/match?name={$itemData['taxon']['scientific_name']}");
//
//                        $gbifData = $responseGBIF->toArray();
//                        if (isset($gbifData['usageKey'])) {
//                            $responseGBIFitem = $this->httpClient->request('GET', "https://api.gbif.org/v1/occurrence/search?taxon_key={$gbifData['usageKey']}");
//                            $gbifDataItem = $responseGBIFitem->toArray();
//                            foreach ($gbifDataItem['results'] as $entityData) {
//                                if (isset($entityData['extensions']) &&
//                                    isset($entityData['extensions']['http://rs.gbif.org/terms/1.0/Multimedia'])) {
//
//                                    $multimedia = $entityData['extensions']['http://rs.gbif.org/terms/1.0/Multimedia'];
//                                    if (!empty($multimedia)) {
//                                        $firstItem = $multimedia[0];
//                                        if (isset($firstItem['http://purl.org/dc/terms/identifier'])) {
//                                            $entityObject->setImageSrc($firstItem['http://purl.org/dc/terms/identifier']);
//                                            break;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                        $this->entityManager->persist($entityObject);
//                        $this->entityManager->flush();
//                        usleep(500000);
//                    }
//                }
//            }
//
//        }

        return $this->render('homepage-body.html.twig',[
            'pageTitle' => "Red Book",
            'test' => 'Okkk',
        ]);
//
//
//        $url = 'https://api.gbif.org/v1/species?offset=1600&limit=20';
//
//        $response = $this->httpClient->request('GET', $url);
//
//        $data = $response->toArray();
//
//        foreach ($data['results'] as &$item) {
//            $url2 = 'https://api.gbif.org/v1/occurrence/search?taxonKey=' . $item['key'];
//            $response2 = $this->httpClient->request('GET', $url2);
//            $entity = $response2->toArray();
//
//            foreach ($entity['results'] as $entityData) {
//                if (isset($entityData['extensions']) &&
//                    isset($entityData['extensions']['http://rs.gbif.org/terms/1.0/Multimedia'])) {
//
//                    $multimedia = $entityData['extensions']['http://rs.gbif.org/terms/1.0/Multimedia'];
//                    if (!empty($multimedia)) {
//                        $firstItem = $multimedia[0];
//                        if (isset($firstItem['http://purl.org/dc/terms/identifier'])) {
//                            $item['imageSrc'] = $firstItem['http://purl.org/dc/terms/identifier'];
//                            break;
//                        }
//                    }
//                }
//            }
//            $url3 = 'https://api.gbif.org/v1/species/'.$item['key'].'/descriptions';
//            $response3 = $this->httpClient->request('GET', $url3);
//            $des = $response3->toArray();
//            if(isset($des['results'][0]['description'])) {
//                $item['des'] = $des['results'][0]['description'];
//            }
//        }
//
//        return $this->render('homepage-body.html.twig',[
//            'pageTitle' => "Red Book",
//            'test' => $data['results'],
//        ]);;
    }
}