<?php

declare(strict_types=1);

namespace Folder\Controller;

use Common\Service\ExceptionMessenger;
use Common\Service\MessageBusDispatcher;
use Folder\Command\Create\CreateFolderCommand;
use Folder\Command\Delete\DeleteFolderCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class FolderController extends AbstractController
{
    public function __construct(
        private readonly MessageBusDispatcher $dispatcher,
    ) {
    }

    #[Route(path: '/api/folder', name: 'app.folder.create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload]
        CreateFolderCommand $command
    ): JsonResponse {
        try {
            $this->dispatcher->dispatchCommand($command);
            return $this->json([], 201);
        } catch (BadRequestHttpException $exception) {
            return $this->json(ExceptionMessenger::buildMessage(400, $exception), 400);
        } catch (\Exception $exception) {
            return $this->json(ExceptionMessenger::buildMessage(500, $exception), 500);
        }
    }

    public function rename()
    {

    }

    public function move()
    {

    }

    #[Route(path: '/api/folder/{folder_id}', name: 'app.folder.destroy', methods: ['DELETE'])]
    public function destroy(?Uuid $folder_id): JsonResponse
    {
        try {
            $this->dispatcher->dispatchCommand(new DeleteFolderCommand($folder_id));
            return $this->json([], 201);
        } catch (NotFoundHttpException $exception) {
            return $this->json(ExceptionMessenger::buildMessage(404, $exception), 404);
        } catch (\Exception $exception) {
            return $this->json(ExceptionMessenger::buildMessage(500, $exception), 500);
        }
    }
}
