<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/api/customer", methods={"GET","HEAD"})
     */
    public function getCustomerList(CustomerRepository $customerRepository): Response
    {
        $customers = $customerRepository->findAll();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $customers
            ],
        200
        );
    }

    /**
     * @Route("/api/customer", methods={"POST"})
     */
    public function createCustomer(EntityManagerInterface $manager, Request $request): Response
    {
        $customerData = $request->request->all();

        $customer = new Customer();
        $customer->setCustomerNumber($customerData['customerNumber'])
            ->setFullName($customerData['fullName'])
            ->setEmail($customerData['email'])
            ->setPhone($customerData['phone'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($customer);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $customer
            ],
            200
        );
    }

    /**
     * @Route("/api/customer/{id}", methods={"PUT"})
     */
    public function updateCustomer(CustomerRepository $customerRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $customerData = $request->request->all();
        $customer = $customerRepository->find($request->get('id'));

        $customer->setCustomerNumber($customerData['customerNumber'])
            ->setFullName($customerData['fullName'])
            ->setEmail($customerData['email'])
            ->setPhone($customerData['phone'])
            ->setCreateDate(new \DateTime())
            ->setUpdateDate(new \DateTime());

        $manager->persist($customer);
        $manager->flush();

        return new JsonResponse(
            [
                'success' => true,
                'data' => $customer
            ],
            200
        );
    }

    /**
     * @Route("/api/customer/{id}", methods={"DELETE"})
     */
    public function deleteCustomer(CustomerRepository $customerRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $customer = $customerRepository->find($request->get('id'));
        $success = true;
        $message = 'Customer ' . $request->get('id') . ' was deleted.';


        try {
            $manager->remove($customer);
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
