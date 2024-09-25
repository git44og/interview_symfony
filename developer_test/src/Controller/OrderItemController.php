<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderItemController extends AbstractController
{
    /**
     * @Route("/api/orderitem", methods={"GET","HEAD"})
     */
    public function getOrderItemList(OrderItemRepository $orderItemRepository): Response
    {
        $orderItems = $orderItemRepository->findAll();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $orderItems
            ],
            200
        );
    }

    /**
     * @Route("/api/order", methods={"POST"})
     */
    public function createOrderItem(EntityManagerInterface $manager, Request $request): Response
    {
        $orderItemData = $request->request->all();

        $orderItem = new OrderItem();
        $orderItem->setProductNumber($orderItemData['productNumber'])
            ->setAmount($orderItemData['amount'])
            ->setVat($orderItemData['vat'])
            ->setTitle($orderItemData['title'])
            ->setPrice($orderItemData['price'])
            ->setPriceTotal($orderItemData['priceTotal'])
            ->setRelatedOrder($orderItemData['relatedOrder'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($orderItem);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $orderItem
            ],
            200
        );
    }

    /**
     * @Route("/api/order/{id}", methods={"PUT"})
     */
    public function updateOrderItem(OrderItemRepository $orderItemRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $orderItemData = $request->request->all();

        $orderItem = $orderItemRepository->find($request->get('id'));
        $orderItem->setProductNumber($orderItemData['productNumber'])
            ->setAmount($orderItemData['amount'])
            ->setVat($orderItemData['vat'])
            ->setTitle($orderItemData['title'])
            ->setPrice($orderItemData['price'])
            ->setPriceTotal($orderItemData['priceTotal'])
            ->setRelatedOrder($orderItemData['relatedOrder'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($orderItem);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $orderItem
            ],
            200
        );
    }

    /**
     * @Route("/api/order/{id}", methods={"DELETE"})
     */
    public function deleteOrder(OrderItemRepository $orderItemRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $orderItem = $orderItemRepository->find($request->get('id'));
        $success = true;
        $message = 'OrderItem ' . $request->get('id') . ' was deleted.';


        try {
            $manager->remove($orderItem);
            $manager->flush();
        } catch(\Exception $exception) {
            $success = false;
            $message = $exception->getMessage();
        }

        return new JsonResponse(
            [
                'success' => $success,
                'message' => $message
            ],
            200
        );
    }
}
