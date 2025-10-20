<?php

declare(strict_types=1);

namespace File\Entity;

use Doctrine\ORM\Mapping as ORM;
use File\Repository\FileRepository;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use User\Entity\User;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id;

    public function __construct(
        #[ORM\Column(nullable: false)]
        public string $original_name,

        #[ORM\Column(nullable: false)]
        public string $file_path,

        #[ORM\Column(nullable: false)]
        public string $mime_type,

        #[ORM\Column(nullable: false)]
        public string $format,

        #[ORM\Column(nullable: false)]
        public int $size,

        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'files')]
        public ?User $user
    ) {
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
