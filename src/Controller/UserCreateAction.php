<?php

declare(strict_types=1);

namespace App\Controller;
use ApiPlatform\Symfony\Validator\Validator;
use ApiPlatform\Validator\ValidatorInterface;
use App\component\User\UserFactory;
use App\component\User\UserManager;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateAction extends AbstractController
{
    public function __construct(
        private UserFactory $userFactory,
        private UserManager $userManager,
        private ValidatorInterface $validator
    )
    {
    }

    public function __invoke(User $user): User
    {
        $this->validator->validate($user);

        $user = $this->userFactory->create(
            $user->getFullName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhoto()
        );
        $this->userManager->save($user, true);

        return $user;
    }
}
