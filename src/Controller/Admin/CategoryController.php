<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Utils\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;



class CategoryController extends AbstractController
{
    #[Route('/admin/category/list', name: 'admin_category_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['id' => 'DESC']);

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/admin/product/edit{id}', name: 'admin_category_edit')]
    #[Route('/admin/product/add', name: 'admin_product_add')]
    public function edit(Request $request,  Category $category = null, ManagerRegistry $doctrine): Response
    {
        //
    }
    #[Route('/admin/category/delete{id}', name: 'admin_category_delete')]
    public function delete(Category $category): Response
    {
        //
    }
}
