<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/api/order", methods={"GET","HEAD"})
     */
    public function getOrderList(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $orders
            ],
            200
        );
    }

    /**
     * @Route("/api/order", methods={"POST"})
     */
    public function createOrder(EntityManagerInterface $manager, Request $request): Response
    {
        $orderData = $request->request->all();

        $order = new Order();
        $order->setOrderNumber($orderData['orderNumber'])
            ->setSum($orderData['sum'])
            ->setVat($orderData['vat'])
            ->setCustomer($orderData['customer'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($order);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $order
            ],
            200
        );
    }

    /**
     * @Route("/api/order/{id}", methods={"PUT"})
     */
    public function updateOrder(OrderRepository $orderRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $orderData = $request->request->all();
        $order = $orderRepository->find($request->get('id'));

        $order->setOrderNumber($orderData['orderNumber'])
            ->setSum($orderData['sum'])
            ->setVat($orderData['vat'])
            ->setCustomer($orderData['customer'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($order);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $order
            ],
            200
        );
    }

    /**
     * @Route("/api/order/{id}", methods={"DELETE"})
     */
    public function deleteOrder(OrderRepository $orderRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $order = $orderRepository->find($request->get('id'));
        $success = true;
        $message = 'Order ' . $request->get('id') . ' was deleted.';


        try {
            $manager->remove($order);
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
