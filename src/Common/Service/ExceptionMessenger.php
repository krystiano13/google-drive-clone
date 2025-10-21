<?php

declare(strict_types=1);

namespace Common\Service;

final readonly class ExceptionMessenger
{
    /**
     * @param int $code
     * @param \Exception $exception
     * @return array<mixed>
     */
    public static function buildMessage(int $code, \Exception $exception): array
    {
        return [
            'code' => $code,
            'message' => $exception->getMessage()
        ];
    }
}
