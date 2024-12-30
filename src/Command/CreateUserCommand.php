<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    // Inyectamos el servicio de password hasher
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this->setName('app:create-user')
             ->setDescription('Crea un usuario con contraseña hasheada.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Los datos del nuevo usuario
        $email = 'test@correo.com'; // El email del usuario
        $plainPassword = '12345678'; // La contraseña en texto claro

        // Creamos el usuario
        $user = new User();
        $user->setEmail($email); // Asignamos el email
        $user->setRoles(['ROLE_USER']); // Asignamos roles (puedes agregar más roles si lo necesitas)

        // Hasheamos la contraseña
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Persistimos el usuario en la base de datos
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Usuario creado exitosamente.');

        return Command::SUCCESS;
    }
}
