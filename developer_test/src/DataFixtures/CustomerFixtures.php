<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    protected $customers = [
        [
            'customerNumber' => 'A1234GH31',
            'fullName' => 'Andreas Elstner',
            'email' => 'andreas.elstner@orcaya.com',
            'phone' => '0711/62139298'
        ],
        [
            'customerNumber' => 'A1234GH32',
            'fullName' => 'Christoph Mayer',
            'email' => 'christoph.mayer@orcaya.com',
            'phone' => '0711/62139297'
        ],
        [
            'customerNumber' => 'A1234GH33',
            'fullName' => 'Max Mustermann',
            'email' => 'max.mustermann@orcaya.com',
            'phone' => '0711/62139299'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        foreach($this->customers as $customerData) {
            $customer = new Customer();
            $customer->setCustomerNumber($customerData['customerNumber'])
                ->setFullName($customerData['fullName'])
                ->setEmail($customerData['email'])
                ->setPhone($customerData['phone'])
                ->setCreateDate(new \DateTime())
                ->setUpdateDate(new \DateTime());

            $manager->persist($customer);
            $manager->flush();

            $this->addReference($customerData['email'],$customer);
        }
    }
}
