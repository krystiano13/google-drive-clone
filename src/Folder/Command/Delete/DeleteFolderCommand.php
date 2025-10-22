<?php

declare(strict_types=1);

namespace Folder\Command\Delete;

use Common\Interface\CommandInterface;
use Symfony\Component\Uid\Uuid;

final readonly class DeleteFolderCommand implements CommandInterface
{
    public function __construct(
        public ?Uuid $folder_id
    ) {
    }
}
