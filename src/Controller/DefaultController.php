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
//        dd($producList);

        return $this->render('main/default/index.html.twig', []);
    }

    #[Route('/product-add', methods: 'GET', name: 'product_add_old')]
    public function productAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setTitle('Product'. rand(1,100));
        $product->setDescription('desc');
        $product->setPrice(rand(1,10));
        $product->setQuantity(1);

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }


    #[Route('/edit-product/{id}', methods: ['GET','POST'], name: 'product_edit', requirements: ['id' => '\d+'])]
    #[Route('/add-product', methods: ['GET','POST'], name: 'product_add')]
    public function editProduct(Request $request, int $id = null, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id){
            $product = $productRepository->find($id);
        } else {
            $product = new Product();
        }
        $form = $this->createForm(EditProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product_edit',['id'=>$product->getId()]);
        }
        return $this->render('main/default/edit_product.html.twig', [
            'form'=>$form->createView()
        ]);

    }

}
