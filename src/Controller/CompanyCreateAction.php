<?php
declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\component\Company\CompanyFactory;
use App\component\Company\CompanyManager;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

class CompanyCreateAction extends AbstractController
{
    public function __construct(
        private CompanyFactory $companyFactory,
        private CompanyManager $companyManager,
        private ValidatorInterface $validator,
        private Security $security
    )
    {
    }

    public function __invoke(Company $company): Company
    {
        $this->validator->validate($company);

        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            throw new \RuntimeException("Kompaniya yaratish uchun tizimga kirish shart");
        }

        $company = $this->companyFactory->create(
            $company->getName(),
            $company->getEmail(),
            $company->getPassword(),
            $currentUser
        );
        $this->companyManager->save($company, true);

        return $company;
    }
}
