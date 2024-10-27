<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EntityObject;

class ElementController extends AbstractController 
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function loadElementById(int $entity_id) {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('eo')
            ->from(EntityObject::class, 'eo')
            ->where('eo.id = :entity_id')
            ->setParameter('entity_id', $entity_id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    private function getCountryCodesByName(string $name): array {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('c.Country_code')
            ->from(EntityObject::class, 'eo')
            ->join('eo.Countries', 'c')
            ->where('eo.Name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getResult();
    }

    private function getCountryNamesbyCountryCodes(array $countryCodes): array {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('c.Country_name')
            ->from(Country::class, 'c')
            ->where('c.Country_code IN (:countryCodes)')
            ->setParameter('countryCodes', $countryCodes);

        // Отримуємо результати
        $results = $qb->getQuery()->getResult();

        return array_map(function($result) {
            return $result['Country_name'];
        }, $results);
    }

    public function elementPage(int $element_id): Response {

        $entity = $this->loadElementById($element_id);
        $countryCodes = $this->getCountryCodesByName($entity->getName());
        $countryNames = $this->getCountryNamesbyCountryCodes($countryCodes);

        return $this->render('page-element.html.twig', [
            'animal' => $entity,
            'countries'=>$countryNames
        ]);
    }
}