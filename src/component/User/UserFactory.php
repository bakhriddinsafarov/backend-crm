<?php

declare(strict_types=1);

namespace App\component\User;

use App\Entity\User;
use Symfony\Component\Clock\DatePoint;

class UserFactory
{
    public function create(
        string $fullName,
        string $email,
        string $password,
        ?\App\Entity\MediaObject $photo
    ): User
    {
        $user = new User();

        $user->setFullName($fullName);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setPhoto($photo);

        $user->setCreatedAt(new DatePoint(timezone: new \DateTimeZone('Asia/Tashkent')));

        return $user;
    }
}
