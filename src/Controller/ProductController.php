<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use ContainerLUkPwBe\PaginatorInterface_82dac15;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/indexProduct.html.twig', [
            'Products' => $productRepository->findAll(),
        ]);
    }

     //funcion para mosstrar un solo registro busca por id 
     #[Route('/product/show/{id}', name: 'product_show')]
     public function show(Product $product): Response
     {
         return $this->render('product/showProduct.html.twig', [
             'product' => $product,
         ]);
     }

    //funcion para guardar registros de productos
    #[Route('/product/post', name: 'form_product')]
    public function postProduct(Request $request , ProductRepository $productRepository): Response {
        $product= new Product();
         $form=$this->createForm(ProductType::class,$product);
         $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid()) {

            /*estos dos set se hiceron para no pedir la fecha de creacion ya deberia ser la misma 
            del servidor , igual con active ya que este cuando se crea deberia ser siempre true */
            $product->setCreatedAt(new DateTimeImmutable('now'));
            $product->setUpdatedAt(new DateTimeImmutable('now'));

            $productRepository->add($product, true);
            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
         }
         return $this->renderForm('product/formProduct.html.twig', [
            'form' => $form,
        ]);
    }

    //funcion para editar
    #[Route('/product/put/{id}', name: 'product_put')]
    public function put(Request $request,Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            return $this->redirectToRoute('app_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/formputProduct.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
