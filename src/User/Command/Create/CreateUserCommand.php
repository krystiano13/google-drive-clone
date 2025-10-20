<?php

declare(strict_types=1);

namespace User\Command\Create;

use Common\Interface\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public string $user_name,

        #[Assert\Email]
        public string $email,

        #[Assert\Length(min: 6)]
        public string $password,

        #[Assert\Length(min: 6)]
        public string $confirm_password
    ) {
    }
}
