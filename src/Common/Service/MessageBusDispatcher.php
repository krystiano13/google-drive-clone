<?php

declare(strict_types=1);

namespace Common\Service;

use Common\Interface\CommandInterface;
use Common\Interface\QueryInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\StampInterface;

final readonly class MessageBusDispatcher
{
    public function __construct(
        private MessageBusInterface $queryBus,
        private MessageBusInterface $commandBus,
    ) {
    }

    public function dispatchQuery(QueryInterface $query): object|array
    {
        $query = $this->queryBus->dispatch($query);
        $last = $query->last(HandledStamp::class);

        return $last instanceof StampInterface ? $last->getResult() : [];
    }

    public function dispatchCommand(CommandInterface $command): object|array|bool|null
    {
        $command = $this->commandBus->dispatch($command);
        $last = $command->last(HandledStamp::class);

        if (!$last instanceof StampInterface) {
            return [];
        }

        return $last->getResult();
    }
}
