<?php

declare(strict_types=1);

namespace Share\Entity;

use Doctrine\ORM\Mapping as ORM;
use File\Entity\File;
use Share\Repository\FileShareRepository;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use User\Entity\User;

#[ORM\Entity(repositoryClass: FileShareRepository::class)]
class FileShare
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: File::class, inversedBy: 'fileShares')]
        public ?File $file,

        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'fileShares')]
        public ?User $owner,

        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'fileShares')]
        public ?User $shared_with,
    ) {
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
