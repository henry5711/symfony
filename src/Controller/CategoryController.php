<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactory;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/indexCategory.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    //funcion para mosstrar un solo registro busca por id 
    #[Route('/category/show/{id}', name: 'category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/showCategory.html.twig', [
            'category' => $category,
        ]);
    }

    //funcion para guardar registros de categorias
    #[Route('/category/post', name: 'form_category')]
    public function post(Request $request , CategoryRepository $categoryRepository): Response {
        $category= new Category();
         $form=$this->createForm(CategoryType::class,$category);
         $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid()) {

            /*estos tres set se hiceron para no pedir la fecha de creacion ya deberia ser la misma 
            del servidor , igual con active ya que este cuando se crea deberia ser siempre true */
            $category->setCreatedAt(new DateTimeImmutable('now'));
            $category->setUpdatedAt(new DateTimeImmutable('now'));
            $category->setActive(true);

            $categoryRepository->add($category, true);
            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
         }
         return $this->renderForm('category/formCategory.html.twig', [
            'form' => $form,
        ]);
    }

  //funcion para editar
    #[Route('/category/put/{id}', name: 'category_edit')]
    public function put(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/formputCategory.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    //funcion para borrar no logre incorporar la funcion eliminar a los templates pero plantee el controlador
    #[Route('/delete/{id}', name: 'category_delete')]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
       //llamo al repo la funcion borrar
        $categoryRepository->remove($category, true);
        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }


}
