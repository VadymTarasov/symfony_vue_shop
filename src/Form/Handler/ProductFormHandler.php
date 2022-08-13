<?php
namespace App\Form\Handler;



use App\Entity\Product;
use App\Utils\File\FileSaver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class ProductFormHandler
{


    private EntityManagerInterface $entityManager;
    private FileSaver $fileSaver;

    public function __construct(EntityManagerInterface $entityManager, FileSaver $fileSaver)
    {

        $this->entityManager = $entityManager;
        $this->fileSaver = $fileSaver;
    }

    public function processEditForm(Product $product, Form $form)
    {
//        dd($product);
        $this->entityManager->persist($product);

        $newImageFile = $form->get('newImage')->getData();

        $tempImageFilename = $newImageFile
            ? $this->fileSaver->saveUploadedFileIntoTemp($newImageFile)
            : null;
        dd($tempImageFilename);


        $this->entityManager->flush();
        return $product;

    }

}
