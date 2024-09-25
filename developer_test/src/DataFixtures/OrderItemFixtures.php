<?php

namespace App\DataFixtures;

use App\Entity\OrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture
{
    protected $orderItems = [
        'ORD1223' => [
            [
                'productNumber' => 'P1111',
                'price' => 600.0,
                'amount' => 1,
                'priceTotal' => 600.0,
                'title' => 'Artikel 1',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1112',
                'price' => 600.0,
                'amount' => 1,
                'priceTotal' => 600.0,
                'title' => 'Artikel 2',
                'vat' => 19.00
            ]
        ],
        'ORD1224' => [
            [
                'productNumber' => 'P1113',
                'price' => 200.0,
                'amount' => 1,
                'priceTotal' => 200.0,
                'title' => 'Artikel 3',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1114',
                'price' => 100.0,
                'amount' => 3,
                'priceTotal' => 300.0,
                'title' => 'Artikel 4',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1115',
                'price' => 50.0,
                'amount' => 4,
                'priceTotal' => 200.0,
                'title' => 'Artikel 5',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1116',
                'price' => 50.0,
                'amount' => 3,
                'priceTotal' => 150.0,
                'title' => 'Artikel 6',
                'vat' => 19.00
            ]
        ],
        'ORD1225' => [
            [
                'productNumber' => 'P1117',
                'price' => 50.0,
                'amount' => 2,
                'priceTotal' => 100.0,
                'title' => 'Artikel 7',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1118',
                'price' => 100.0,
                'amount' => 1,
                'priceTotal' => 100.0,
                'title' => 'Artikel 8',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1119',
                'price' => 20.0,
                'amount' => 5,
                'priceTotal' => 100.0,
                'title' => 'Artikel 9',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1120',
                'price' => 30.0,
                'amount' => 3,
                'priceTotal' => 90.0,
                'title' => 'Artikel 10',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1121',
                'price' => 10.0,
                'amount' => 1,
                'priceTotal' => 10.0,
                'title' => 'Artikel 11',
                'vat' => 19.00
            ],
            [
                'productNumber' => 'P1122',
                'price' => 249.99,
                'amount' => 1,
                'priceTotal' => 249.99,
                'title' => 'Artikel 12',
                'vat' => 19.00
            ]
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach($this->orderItems as $orderNumber => $orderItems) {
            foreach($orderItems as $orderItemData) {
                $orderItem = new OrderItem();
                $orderItem->setVat($orderItemData['vat'])
                    ->setAmount($orderItemData['amount'])
                    ->setPrice($orderItemData['price'])
                    ->setPriceTotal($orderItemData['priceTotal'])
                    ->setProductNumber($orderItemData['productNumber'])
                    ->setTitle($orderItemData['title'])
                    ->setRelatedOrder($this->getReference($orderNumber))
                    ->setCreateDate(new \DateTime())
                    ->setUpdateDate(new \DateTime());
                $manager->persist($orderItem);
                $manager->flush();
            }
        }
    }

    public function getDependencies()
    {
        return [
            OrderFixtures::class,
        ];
    }
}
