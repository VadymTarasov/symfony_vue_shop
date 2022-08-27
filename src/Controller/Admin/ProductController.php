<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\EditProductFormType;
use App\Form\Handler\ProductFormHandler;
use App\Form\Model\EditProductModel;
use App\Repository\ProductRepository;
use App\Utils\Manager\ProductManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/admin/product/list', name: 'admin_product_list')]
    public function list(ProductRepository $productRepository): Response
    {
        $user = $this->getUser();
        $product = $productRepository->findBy(['isDeleted' => false], ['id'=>'DESC'],50);
        return $this->render('admin/product/list.html.twig', [
            'products' => $product,
            'user' => $user,
        ]);
    }

    #[Route('/admin/product/edit{id}', name: 'admin_product_edit')]
    #[Route('/admin/product/add', name: 'admin_product_add')]
    public function edit(Request $request, ProductFormHandler $formHandler, Product $product = null, ManagerRegistry $doctrine): Response
    {


        $editProductModel = EditProductModel::makeFromProduct($product);
//        dd($editProductModel);

        $user = $this->getUser();
        $form = $this->createForm(EditProductFormType::class, $editProductModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($editProductModel);
            $product = $formHandler->processEditForm($editProductModel, $form);


            return $this->redirectToRoute('admin_product_edit', ['id'=>$product->getId()]);
        }

        $images = $product
            ? $product->getProductImages()->getValues()
            : [];

        return $this->render('admin/product/edit.html.twig', [

            'form'=>$form->createView(),
            'product'=>$product,
            'user' => $user,
            'images' => $images,
        ]);
    }

    #[Route('/admin/product/delete{id}', name: 'admin_product_delete')]
    public function delete(Product $product, ProductManager $productManager): Response
    {
        $productManager->remove($product);
        return $this->redirectToRoute('admin_product_list', [
        ]);
    }
}
