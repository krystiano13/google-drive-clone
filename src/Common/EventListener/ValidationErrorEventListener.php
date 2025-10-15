<?php

declare(strict_types=1);

namespace Common\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener]
final class ValidationErrorEventListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof UnprocessableEntityHttpException) {
            $previousException = $exception->getPrevious();
            if ($previousException instanceof ValidationFailedException) {
                $violations = $previousException->getViolations();
                $errors = [];

                foreach ($violations as $violation) {
                    $errors[] = [
                        'field' => $violation->getPropertyPath(),
                        'message' => $violation->getMessage(),
                        'value' => $violation->getInvalidValue(),
                    ];
                }

                $response = new JsonResponse([
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $errors,
                ], 422);

                $event->setResponse($response);
            }
        }
    }
}
