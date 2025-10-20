<?php

declare(strict_types=1);

namespace User\Controller;

use Common\Service\MessageBusDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use User\Command\Create\CreateUserCommand;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusDispatcher $dispatcher
    ) {
    }

    #[Route(path: "/api/user", name: "app_user_register", methods: ["POST"])]
    public function register(
        #[MapRequestPayload]
        CreateUserCommand $command
    ): JsonResponse {
        try {
            $this->dispatcher->dispatchCommand($command);
            return $this->json([], 201);
        } catch (UnprocessableEntityHttpException $exception) {
            return $this->json([
                "message" => $exception->getMessage()
            ], 422);
        } catch (\Exception $exception) {
            return $this->json([
                "message" => $exception->getMessage()
            ], 500);
        }
    }
}
