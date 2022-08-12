<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function edit(): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/admin/product/delete{id}', name: 'admin_product_delete')]
    public function delete(): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
