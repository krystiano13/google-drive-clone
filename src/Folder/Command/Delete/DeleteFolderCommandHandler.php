<?php

declare(strict_types=1);

namespace Folder\Command\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Folder\Repository\FolderRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class DeleteFolderCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entity_manager,
        private FolderRepository $repository
    ) {
    }

    public function __invoke(DeleteFolderCommand $command): void
    {
        $id = Uuid::fromString($command->folder_id->toString());
        $folder = $this->repository->find($id);

        if(!$folder)
        {
            throw new NotFoundHttpException("Folder not found");
        }

        $this->entity_manager->remove($folder);
    }
}
