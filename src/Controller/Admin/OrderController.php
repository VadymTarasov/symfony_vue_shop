<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Repository\OrderRepository;
use App\Utils\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;



class OrderController extends AbstractController
{
    #[Route('/admin/order/list', name: 'admin_order_list')]
    public function list(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        $orders = $orderRepository->findBy(['isDeleted'=>false], ['id' => 'DESC']);

        return $this->render('admin/order/list.html.twig', [
            'orders' => $orders,
            'user' => $user,
            'orderStatusChoices' => OrderStaticStorage::getOrderStatusChoices()
        ]);
    }
    #[Route('/admin/order/edit{id}', name: 'admin_order_edit')]
    #[Route('/admin/order/add', name: 'admin_order_add')]
    public function edit(Request $request, Order $order = null, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        /*
//
        $editCategoryModel = EditCategoryModel::makeFromCategory($order);

        $form = $this->createForm(EditCategoryFormType::class, $editCategoryModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $orderFormHandler->processEditForm($editCategoryModel);

            $this->addFlash('success', 'Your changes were saved!');

            return $this->redirectToRoute('admin_order_edit', ['id' => $order->getId()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('warning', 'Something went wrong. Please check your form!');
        }
        */

        return $this->render('admin/order/edit.html.twig', [
            'order' => $order,
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/order/delete{id}', name: 'admin_order_delete')]
    public function delete(Order $order, OrderManager $orderManager): Response
    {
        $orderManager->remove($order);
        $this->addFlash('warning', 'The order was successfully deleted!');
        return $this->redirectToRoute('admin_order_list');
    }
}
