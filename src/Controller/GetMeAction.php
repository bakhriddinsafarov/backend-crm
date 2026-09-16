<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetMeAction extends AbstractController
{
    public function __invoke(): UserInterface
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Tizimga kirilmagan');
        }

        return $user;
    }
}
