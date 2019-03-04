<?php

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class CustomerService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Create Customer by given data
     *
     * @param $data array which contains information about Customer
     *    $data = [
     *      'firstName' => (string) Customer first name. Required.
     *      'lastName' => (string) Customer last name. Required.
     *      'dateOfBirth' => (date) Customer date of birth. Non-required.
     *      'status' => (string) Customer status. Required.
     *    ]
     * @return Customer|string Customer or error message
     */
    public function createCustomer(array $data)
    {
        if (empty($data['firstName']) || empty($data['lastName']) || empty($data['status'])) {
            return "First Name, Last Name and status must be provided to create new Customer";
        }

        try {

            $customer = new Customer();

            $customer->setFirstName($data['firstName']);
            $customer->setLastName($data['lastName']);
            $customer->setStatus($data['status']);

            if (!empty($data['dateOfBirth'])) {
                $dateBirth = explode("-",$data['dateOfBirth']);
                $customer->setDateOfBirth((new \DateTime())->setDate(
                    $dateBirth[0],
                    $dateBirth[1],
                    $dateBirth[2]
                ));
            } else {
                $customer->setDateOfBirth(null);
            }

            $customer->setCreatedAt(new \DateTime());
            $customer->setUpdatedAt(new \DateTime());

            $this->em->persist($customer);
            $this->em->flush();

            return $customer;
        } catch (\Exception $ex) {
            return "Unable to create Customer";
        }
    }

    /**
     * Update Customer by given data
     *
     * @param Customer $customer
     * @param $data array which contains information about Customer
     *    $data = [
     *      'firstName' => (string) Customer first name. Required.
     *      'lastName' => (string) Customer last name. Required.
     *      'dateOfBirth' => (date) Customer date of birth. Non-required.
     *      'status' => (string) Customer status. Required.
     *    ]
     * @return Customer|string Customer or error message
     */
    public function updateCustomer(Customer $customer, array $data)
    {
        try {

            if (isset($data['firstName'])) {
                $customer->setFirstName($data['firstName']);
            }

            if (isset($data['lastName'])) {
                $customer->setLastName($data['lastName']);
            }

            if (isset($data['status'])) {
                $customer->setStatus($data['status']);
            }

            if (!empty($data['dateOfBirth'])) {
                $dateBirth = explode("-",$data['dateOfBirth']);
                $customer->setDateOfBirth((new \DateTime())->setDate(
                    $dateBirth[0],
                    $dateBirth[1],
                    $dateBirth[2]
                ));
            } else {
                $customer->setDateOfBirth(null);
            }

            $this->em->persist($customer);
            $this->em->flush();

            return $customer;

        }  catch (\Exception $ex) {
            return "Unable to update Customer";
        }
    }

    /**
     * @param Customer $customer
     * @return Customer|string Customer or error message
     */
    public function deleteCustomer(Customer $customer)
    {
        try {
            $customer->setStatus("deleted");
            $customer->setDeletedAt(new \DateTime());

            $this->em->persist($customer);
            $this->em->flush();

            return $customer;

        } catch (\Exception $ex) {
            return "Unable to remove Customer";
        }
    }
}