<?php

declare(strict_types=1);

namespace App\component\Company;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Component\Clock\DatePoint;

class CompanyFactory
{
    public function create(
        string $name,
        string $email,
        string $password,
        User $createdBy
    ): Company
    {
        $company = new Company();

        $company->setName($name);
        $company->setEmail($email);
        $company->setPassword($password);
        $company->setCreatedBy($createdBy);

        $company->setLastActivity(new DatePoint(timezone: new \DateTimeZone('Asia/Tashkent')));
        $company->setCreatedAt(new DatePoint(timezone: new \DateTimeZone('Asia/Tashkent')));

        return $company;
    }
}
