<?php

declare(strict_types=1);

namespace App\component\Customer;

use App\Entity\Company;
use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\Clock\DatePoint;

class CustomerFactory
{
    public function create(
        string $fullName,
        string $email,
        string $password,
        User $createdBy,
        Company $company
    ): Customer
    {
        $customer = new Customer();

        $customer->setFullName($fullName);
        $customer->setEmail($email);
        $customer->setPassword($password);
        $customer->setCreatedBy($createdBy);
        $customer->setCompany($company);

        $customer->setLastActivity(new DatePoint(timezone: new \DateTimeZone('Asia/Tashkent')));
        $customer->setCreatedAt(new DatePoint(timezone: new \DateTimeZone('Asia/Tashkent')));

        return $customer;
    }
}
