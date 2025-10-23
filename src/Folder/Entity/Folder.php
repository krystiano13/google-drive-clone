<?php

declare(strict_types=1);

namespace Folder\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use File\Entity\File;
use Folder\Repository\FolderRepository;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use User\Entity\User;

#[ORM\Entity(repositoryClass: FolderRepository::class)]
class Folder
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id;

    public function __construct(
        #[ORM\Column(nullable: false)]
        public string $folder_name,

        #[ORM\OneToMany(targetEntity: Folder::class, mappedBy: 'parent_folder', cascade: ['remove'])]
        public Collection $folders,

        #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'parent_folder', cascade: ['remove'])]
        public Collection $files,

        #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'folders')]
        public ?User $user,

        #[ORM\ManyToOne(targetEntity: Folder::class, inversedBy: 'folders')]
        public ?Folder $parent_folder,
    ) {
        $this->folders = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
