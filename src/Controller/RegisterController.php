<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $em
    ) {}

    public function __invoke(Request $request)
    {
        $dataUser = json_decode($request->getContent(), true);
        $user = new User();
        $user->setUsername($dataUser['name']);
        $user->setEmail($dataUser['email']);
        $password = $this->passwordHasher->hashPassword($user, $dataUser['password']);
        $user->setPassword($password);
        $user->setRoles([]);
       // dd($user);
       // $user = $this->security->getUser();
        return $user;
    }
}