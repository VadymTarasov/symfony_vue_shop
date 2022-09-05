<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\Model\EditCategoryModel;
use App\Form\EditCategoryFormType;
use App\Form\Handler\CategoryFormHandler;
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
        $user = $this->getUser();
        $categories = $categoryRepository->findBy([], ['id' => 'DESC']);

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
            'user' => $user,
        ]);
    }
    #[Route('/admin/category/edit{id}', name: 'admin_category_edit')]
    #[Route('/admin/category/add', name: 'admin_category_add')]
    public function edit(Request $request, CategoryFormHandler $categoryFormHandler,  Category $category = null, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
//
        $editCategoryModel = EditCategoryModel::makeFromCategory($category);

        $form = $this->createForm(EditCategoryFormType::class, $editCategoryModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $categoryFormHandler->processEditForm($editCategoryModel);

            $this->addFlash('success', 'Your changes were saved!');

            return $this->redirectToRoute('admin_category_edit', ['id' => $category->getId()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('warning', 'Something went wrong. Please check your form!');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/category/delete{id}', name: 'admin_category_delete')]
    public function delete(Category $category): Response
    {
        //
    }
}
