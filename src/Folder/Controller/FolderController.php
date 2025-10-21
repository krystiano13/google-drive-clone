<?php

declare(strict_types=1);

namespace Folder\Controller;

use Common\Service\MessageBusDispatcher;
use Folder\Command\Create\CreateFolderCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class FolderController extends AbstractController
{
    public function __construct(
        private readonly MessageBusDispatcher $dispatcher
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
            return $this->json([
                'code' => 400,
                'message' => $exception->getMessage()
            ], 400);
        } catch (\Exception $exception) {
            return $this->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
