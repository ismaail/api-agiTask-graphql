<?php

declare(strict_types=1);

namespace Domain\Bucket\DataTransferObjects;

class BucketsQueryArgsData
{
    public function __construct(
        public readonly ?bool $archived,
    ) {
    }

    public static function fromArray(array $args): self
    {
        return new self(
            archived: $args['archived'] ?? null,
        );
    }
}
