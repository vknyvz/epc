<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Create product by given data
     *
     * @param $data array which contains information about product
     *    $data = [
     *      'name' => (string) Product name. Required.
     *      'status' => (string) Product status. Non-Required.
     *      'customer' => (int) Customer id. Required.
     *    ]
     * @return Product|string Product or error message
     */
    public function createProduct(array $data)
    {
        if (empty($data['name']) || empty((int)$data['customer'])) {
            return "Name, status and customer id must be provided to create new product";
        }

        try {
            $customer = $this->em
                ->getRepository(Customer::class)
                ->find($data['customer_id']);

            if ($customer) {
                $product = new Product();
                $product->setName($data['name']);

                if (isset($data['status'])) {
                    $product->setStatus($data['status']);
                }

                $product->setCustomer($customer);
                $product->setCreatedAt(new \DateTime());
                $product->setUpdatedAt(new \DateTime());

                $this->em->persist($product);
                $this->em->flush();

                return $product;
            } else {
                return "Unable to find customer";
            }
        } catch (\Exception $ex) {
            return "Unable to create product";
        }
    }

    /**
     * Update product by given data
     *
     * @param Product $product
     * @param $data array which contains information about product
     *    $data = [
     *      'name' => (string) Product name. Required.
     *      'status' => (string) Product status. Required.
     *      'customer' => (int) Customer id. Required.
     *    ]
     * @return Product|string Product or error message
     */
    public function updateProduct(Product $product, array $data)
    {
        try {

            if (isset($data['name'])) {
                $product->setName($data['name']);
            }

            if (isset($data['status'])) {
                $product->setStatus($data['status']);
            }

            $customer = $product->getCustomer();

            if (isset($data['customer'])) {
                if ($customer->getUuid() !== $data['customer']) {
                    $customer = $this->em
                        ->getRepository(Customer::class)
                        ->find($data['customer']);
                    if (!$customer) {
                        return "Unable to find customer to update to";
                    }
                }
            }

            $product->setCustomer($customer);
            $product->setUpdatedAt(new \DateTime());

            $this->em->persist($product);
            $this->em->flush();

            return $product;

        }  catch (\Exception $ex) {
            return "Unable to update product";
        }
    }

    /**
     * @param Product $product
     * @return bool|string True if product was successfully deleted, error message otherwise
     */
    public function deleteProduct(Product $product)
    {
        try {
            $product->setStatus("deleted");
            $product->setDeletedAt(new \DateTime());

            $this->em->persist($product);
            $this->em->flush();

            return $product;

        } catch (\Exception $ex) {
            return "Unable to remove product";
        }
    }
}