<?php

declare(strict_types=1);

namespace Folder\Command\Create;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Folder\Entity\Folder;
use Folder\Repository\FolderRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;
use User\Entity\User;

#[AsMessageHandler]
final readonly class CreateFolderCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entity_manager,
        private FolderRepository $folder_repository,
        private Security $security
    ) {
    }

    public function __invoke(CreateFolderCommand $command): void
    {
        /* @var User $current_user */
        $current_user = $this->security->getUser();

        $check_folder = $this->folder_repository->findBy([
            'user' => $current_user,
            'folder_name' => $command->folder_name
        ]);

        if(count($check_folder) > 0)
        {
            throw new BadRequestHttpException("Folder with this name already exists");
        }

        $parent_id = Uuid::fromString($command->parent_folder_id->toString());
        $parent_folder = $this->folder_repository->find($parent_id);

        $folder = new Folder(
            $command->folder_name,
            new ArrayCollection(),
            new ArrayCollection(),
            $current_user,
            $parent_folder
        );

        $this->entity_manager->persist($folder);
    }
}
