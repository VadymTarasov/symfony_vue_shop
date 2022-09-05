<?php

namespace App\Form\Handler;

use App\Entity\Category;
use App\Form\Model\EditCategoryModel;
use App\Utils\Manager\CategoryManager;

class CategoryFormHandler
{

    private CategoryManager $categoryManager;

    public function __construct(CategoryManager $categoryManager)
    {

        $this->categoryManager = $categoryManager;
    }

    /**
     * @param EditCategoryModel $editCategoryModel
     * @return Category|null
     */
    public function processEditForm(EditCategoryModel $editCategoryModel)
    {
//        dd($category);
        $category = new Category();

        if ($editCategoryModel->id) {
            $category = $this->categoryManager->find($editCategoryModel->id);
        }
//
        $category->setTitle($editCategoryModel->title);
//
        $this->categoryManager->save($category);

        return $category;
    }
}