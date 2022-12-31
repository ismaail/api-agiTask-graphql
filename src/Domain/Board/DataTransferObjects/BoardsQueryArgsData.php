<?php

declare(strict_types=1);

namespace Domain\Board\DataTransferObjects;

class BoardsQueryArgsData
{
    public function __construct(
        public readonly int $limit,
        public readonly int $page,
        public readonly ?bool $archived,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            limit: $args['limit'],
            page: $args['page'],
            archived: $args['archived'] ?? null,
        );
    }
}
