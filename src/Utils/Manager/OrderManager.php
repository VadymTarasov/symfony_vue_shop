<?php

namespace App\Utils\Manager;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class OrderManager extends AbstractBaseManager
{

    private CartManager $cartManager;

    public function __construct(EntityManagerInterface $entityManager, CartManager $cartManager)
    {
        parent::__construct($entityManager);
        $this->cartManager = $cartManager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Order::class);
    }

    /**
     * @param string $sessionId
     * @param User $user
     * @return void
     */
    public function createOrderFromCartBySessionId(string $sessionId, User $user)
    {
        $cart = $this->cartManager->getRepository()->findOneBy(['sessionId' => $sessionId]);
        if ($cart) {
            $this->createOrderFromCart($cart, $user);
        }
    }

    public function createOrderFromCart(Cart $cart, User $user)
    {
//        dd($user);

        $order = new Order();
        $order->setOwner($user);
        $order->setStatus(OrderStaticStorage::ORDER_STATUS_CREATED);
        $orderTotalPrice = 0;


        foreach ($cart->getCartProducts()->getValues() as $cartProduct) {
            $product = $cartProduct->getProduct();

            $orderProduct = new OrderProduct();
            $orderProduct->setAppOrder($order);
            $orderProduct->setQuantity($cartProduct->getQuantity());
            $orderProduct->setPricePerOne($product->getPrice());
            $orderProduct->setProduct($product);

            $orderTotalPrice += $orderProduct->getQuantity() * $orderProduct->getPricePerOne();


            $order->addOrderProduct($orderProduct);

            $this->entityManager->persist($orderProduct);
        }



        $order->setTotalPrice($orderTotalPrice);
//        $order->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->cartManager->delete($cart);


        dd($order);


    }

    /**
     * @param object $entity
     */
    public function saveOrder(object $entity)
    {
        $entity->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }


    /**
     * @param Order $order
     */
    public function remove(object $order)
    {
        $order->setIsDeleted(true);


        $this->save($order);
    }
}