<?php

declare(strict_types=1);

namespace App\component\Company;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

readonly class CompanyManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function save(Company $company, bool $isNeedFlush = false): void
    {
        $this->entityManager->persist($company);

        if ($isNeedFlush) {
            $this->entityManager->flush();
        }
    }
}
