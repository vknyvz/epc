<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCustomers($manager);
        $this->loadProducts($manager);
    }

    public function loadProducts(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < rand(1, 10); $j++) {
                $product = new Product();

                $statusArray = ["new", "pending", "in review", "approved", "inactive", "deleted"];
                $randomStatusValue = rand(0, 5);

                $product->setName($this->faker->sentence($nbWords = 4, $variableNbWords = true))
                    ->setStatus($statusArray[$randomStatusValue])
                    ->setCreatedAt($this->faker->dateTimeThisYear())
                    ->setUpdatedAt($this->faker->dateTimeThisYear())
                    ->setCustomer($this->getReference('customer_'.$j));

                $manager->persist($product);
            }
        }

        $manager->flush();
    }

    public function loadCustomers(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();

            $genderArray = ['male', 'female'];

            $statusArray = ["active", "non-active"];

            $customer->setFirstName($this->faker->firstName($genderArray[rand(0, 1)]))
                ->setLastName($this->faker->lastName())
                ->setDateOfBirth($this->faker->dateTimeThisCentury())
                ->setStatus($statusArray[rand(0, 1)])
                ->setCreatedAt($this->faker->dateTimeThisYear())
                ->setUpdatedAt($this->faker->dateTimeThisYear())
                ;

            $this->setReference("customer_".$i, $customer);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
