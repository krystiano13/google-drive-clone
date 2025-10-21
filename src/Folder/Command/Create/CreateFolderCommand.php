<?php

declare(strict_types=1);

namespace Folder\Command\Create;

use Common\Interface\CommandInterface;
use Symfony\Component\Uid\Uuid;

final readonly class CreateFolderCommand implements CommandInterface
{
    public function __construct(
        public string $folder_name,
        public ?Uuid $parent_folder_id = null
    ) {
    }
}
