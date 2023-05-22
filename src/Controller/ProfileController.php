<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Profil de l\'utilisateur',
        ]);
    }

    #[Route('/commandes', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
        ]);
    }
    #[Route('/panier', name: 'indexpanier')]
    public function indexpanier(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $panier = $session->get("panier", []);

        //on fabrique les données
        $dataPanier = [];
        $total =0;

        foreach ($panier as $id => $quantite){
            $product = $productsRepository->find($id);
            $dataPanier[]= [
                "produit"=>$product,
                "quantite"=>$quantite
            ];
            $total += $product->getPrice() * $quantite;
        }
        return $this->render('profile/panier.html.twig', compact("dataPanier", "total"));
    }
    #[Route('/panier/{id}', name: 'panier')]
    public function add(Products $product, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if (!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }

        //on sauvegarde dans la session
        $session->set("panier", $panier);

        return $this-> redirectToRoute("profile_indexpanier");
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $product, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if (!empty($panier[$id])){
            if ($panier[$id]>1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }

        }else{
            $panier[$id]=1;
        }

        //on sauvegarde dans la session
        $session->set("panier", $panier);

        return $this-> redirectToRoute("profile_indexpanier");
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $product, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if (!empty($panier[$id])){
                unset($panier[$id]);
            }
        //on sauvegarde dans la session
        $session->set("panier", $panier);

        return $this-> redirectToRoute("profile_indexpanier");
    }
}
