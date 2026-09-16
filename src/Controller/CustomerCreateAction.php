<?php
declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\component\Customer\CustomerFactory;
use App\component\Customer\CustomerManager;
use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

class CustomerCreateAction extends AbstractController
{
    public function __construct(
        private CustomerFactory $customerFactory,
        private CustomerManager $customerManager,
        private ValidatorInterface $validator,
        private Security $security
    )
    {
    }

    public function __invoke(Customer $customer): Customer
    {
        $this->validator->validate($customer);

        $currentUser = $this->security->getUser();

        if (!$currentUser) {
            throw new \RuntimeException("Mijoz yaratish uchun tizimga kirish shart");
        }

        $customer = $this->customerFactory->create(
            $customer->getFullName(),
            $customer->getEmail(),
            $customer->getPassword(),
            $currentUser,
            $customer->getCompany()
        );
        $this->customerManager->save($customer, true);

        return $customer;
    }
}
