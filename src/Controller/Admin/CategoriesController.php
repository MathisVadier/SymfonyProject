<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Products;
use App\Form\CategoriesFormType;
use App\Form\ProductsFormType;
use App\Repository\CategoriesRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Categorie;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {

        $categories = $categoriesRepository->findAll();
        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajout', name: 'addcat')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger,): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //On crée une "nouvelle catégorie"
        $category = new Categories();

        // On crée le formulaire
        $categoryForm = $this->createForm(CategoriesFormType::class, $category);


        // On traite la requête du formulaire
        $categoryForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {

            // On génère le slug
            $slug = $slugger->slug($category->getName());
            $category->setSlug($slug);

            // On stocke
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'Catégorie ajouté avec succès');

            // On redirige
            return $this->redirectToRoute('admin_categories_index');
        }


        // return $this->render('admin/products/add.html.twig',[
        //     'productForm' => $productForm->createView()
        // ]);

        return $this->renderForm('admin/categories/add.html.twig', compact('categoryForm'));
        // ['productForm' => $productForm]
    }

    #[Route('delete/{id}', name: 'delete', methods: ['POST'])]
    public function deleteCategorie(Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository, $id): Response
    {
        $categorie = $categoriesRepository->find($id);

        // Vérifiez si la catégorie existe
        if (!$categorie) {
            throw $this->createNotFoundException(
                'La catégorie n\'existe pas.'
            );
        }

        $entityManager->remove($categorie);
        $entityManager->flush();

        $this->addFlash('success', 'La catégorie a été supprimée avec succès.');

        return $this->redirectToRoute('admin_categories_index');
    }

}




