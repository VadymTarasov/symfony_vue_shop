<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\EditProductFormType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'main_homepage')]
    public function index(ProductRepository $productRepository): Response
    {
        $producList = $productRepository->findAll();

        return $this->render('main/default/index.html.twig', []);
    }


}
