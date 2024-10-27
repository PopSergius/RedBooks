<?php

namespace App\Controller;

use App\Entity\EntityObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\GetRedListCategories;
use App\Services\GetCountryList;

class PageWithCustomFilterController extends AbstractController
{
    private GetRedListCategories $getRedListCategories;
    private GetCountryList $getCountryList;
    private $entityManager;

    public function __construct(GetRedListCategories $getRedListCategories, GetCountryList $getCountryList, EntityManagerInterface $entityManager)
    {
        $this->getRedListCategories = $getRedListCategories;
        $this->getCountryList = $getCountryList;
        $this->entityManager = $entityManager;
    }

    public function pageFilter(Request $request): Response
    {
        $categories = $this->getRedListCategories->getCategoreisList();
        $countries = $this->getCountryList->getCountryList();
        $categoryCode = $request->query->get('category');
        $countryCode = $request->query->get('country');
        $page = $request->query->getInt('page', 1);
        $itemsPerPage = 20;

        if ($request->isMethod('POST')) {
            $categoryCode = $request->request->get('category');
            $countryCode = $request->request->get('country');
        }

        $commonAnimals = $this->findEntitiesByFilters($categoryCode, $countryCode, $page, $itemsPerPage);
        $totalAnimals = $this->countTotalAnimals($categoryCode, $countryCode);

        return $this->render('page-with-filter.html.twig', [
            'categories' => $categories,
            'countries' => $countries,
            'animals' => $commonAnimals,
            'selected_category' => $categoryCode,
            'selected_country' => $countryCode,
            'total_animals' => $totalAnimals,
            'items_per_page' => $itemsPerPage,
            'current_page' => $page,
        ]);
    }

    private function findEntitiesByFilters(?string $categoryCode, ?string $countryCode, int $page, int $itemsPerPage): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('eo, k, cl, f, cat, co')
            ->from(EntityObject::class, 'eo')
            ->leftJoin('eo.Kingdom', 'k')
            ->leftJoin('eo.Classes', 'cl')
            ->leftJoin('eo.Family', 'f')
            ->leftJoin('eo.Category', 'cat')
            ->leftJoin('eo.Countries', 'co')
            ->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        if ($categoryCode) {
            $qb->andWhere('cat.Category_code = :categoryCode')
                ->setParameter('categoryCode', $categoryCode);
        }

        if ($countryCode) {
            $qb->andWhere('co.Country_code = :countryCode')
                ->setParameter('countryCode', $countryCode);
        }

        return $qb->getQuery()->getResult();
    }

    private function countTotalAnimals(?string $categoryCode, ?string $countryCode): int
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('COUNT(eo.id)')
            ->from(EntityObject::class, 'eo')
            ->leftJoin('eo.Category', 'cat')
            ->leftJoin('eo.Countries', 'co');

        if ($categoryCode) {
            $qb->andWhere('cat.Category_code = :categoryCode')
                ->setParameter('categoryCode', $categoryCode);
        }

        if ($countryCode) {
            $qb->andWhere('co.Country_code = :countryCode')
                ->setParameter('countryCode', $countryCode);
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

}