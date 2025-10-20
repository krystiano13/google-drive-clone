<?php

declare(strict_types=1);

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use User\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column]
        public string $user_name,

        #[ORM\Column(unique: true)]
        public string $email,

        #[ORM\Column]
        public string $password,
    ) {
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
