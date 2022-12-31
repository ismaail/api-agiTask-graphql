<?php

declare(strict_types=1);

namespace Domain\User\DataTransferObjects;

class UsersQueryArgsData
{
    public function __construct(
        public readonly int $limit,
        public readonly int $page,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            limit: $args['limit'],
            page: $args['page'],
        );
    }
}
