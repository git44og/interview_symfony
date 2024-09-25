<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    protected $orders = [
        [
            'sum' => 1200.00,
            'vat' => 19.00,
            'orderNumber' => 'ORD1223',
            'customer' => 'andreas.elstner@orcaya.com'
        ],
        [
            'sum' => 850.00,
            'vat' => 19.00,
            'orderNumber' => 'ORD1224',
            'customer' => 'christoph.mayer@orcaya.com'
        ],
        [
            'sum' => 649.99,
            'vat' => 19.00,
            'orderNumber' => 'ORD1225',
            'customer' => 'max.mustermann@orcaya.com'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach($this->orders as $orderData) {
            $order = new Order();
            $order->setSum($orderData['sum'])
                ->setVat($orderData['vat'])
                ->setOrderNumber($orderData['orderNumber'])
                ->setCustomer($this->getReference($orderData['customer']))
                ->setCreateDate(new \DateTime())
                ->setUpdateDate(new \DateTime());

            $manager->persist($order);
            $manager->flush();

            $this->setReference($orderData['orderNumber'], $order);
        }
    }

    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
        ];
    }
}
