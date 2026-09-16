<?php

declare(strict_types=1);

namespace App\component\Customer;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

readonly class CustomerManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Customer $customer, bool $isNeedFlush = false): void
    {
        $this->entityManager->persist($customer);

        if ($isNeedFlush) {
            $this->entityManager->flush();
        }
    }
}
