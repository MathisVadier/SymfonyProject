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

class InfoController extends AbstractController
{
    #[Route('/faq', name: 'faq')]
    public function faq(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/faq.html.twig', []);
    }
    #[Route('/contact', name: 'contact')]
    public function contact(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/contact.html.twig', []);
    }
    #[Route('/cgu', name: 'cgu')]
    public function cgu(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/cgu.html.twig', []);
    }
    #[Route('/cgv', name: 'cgv')]
    public function cgv(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/cgv.html.twig', []);
    }
    #[Route('/chartecookies', name: 'chartecookies')]
    public function chartecookies(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/chartecookies.html.twig', []);
    }
    #[Route('/mentionslegales', name: 'mentionslegales')]
    public function mentionslegales(ManagerRegistry $doctrine): Response
    {
        return $this->render('info/mentionslegales.html.twig', []);
    }

}
