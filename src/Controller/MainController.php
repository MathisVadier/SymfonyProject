<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(ManagerRegistry $doctrine): Response
    {


        $categorie = $doctrine->getRepository(Categories::class)->findBy([], ['categoryOrder' => 'asc']);
        $products = $doctrine->getRepository(Products::class)->findAll();

        return $this->render('main/index.html.twig', [
            'produits' => $products,
            'categories'=> $categorie
        ]);

    }


}
