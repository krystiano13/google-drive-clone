<?php

declare(strict_types=1);

namespace User\Command\Create;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use User\Entity\User;
use User\Repository\UserRepository;

#[AsMessageHandler]
final readonly class CreateUserCommandHandler
{
    public function __construct(
        private UserRepository $user_repository,
        private EntityManagerInterface $entity_manager,
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        // Check if user with given email already exists

        $email_user = $this->user_repository->findOneBy(['email' => $command->email]);

        if($email_user)
        {
            throw new UnprocessableEntityHttpException("User with given email already exists");
        }

        // Check if passwords match

        if($command->password !== $command->confirm_password)
        {
            throw new UnprocessableEntityHttpException("Passwords do not match");
        }

        // Create User Entity and Hash passwords
        $user = new User(
            $command->user_name,
            $command->email,
            $command->password
        );

        $password_hash = $this->hasher->hashPassword(
            $user,
            $command->password
        );

        $user->password = $password_hash;

        // Save User Entity

        $this->entity_manager->persist($user);
    }
}
