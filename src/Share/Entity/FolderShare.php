<?php

namespace Share\Entity;

use Doctrine\ORM\Mapping as ORM;
use Folder\Entity\Folder;
use Folder\Repository\FolderRepository;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use User\Entity\User;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class FolderShare
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'fileShares')]
        public ?Folder $folder,

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
