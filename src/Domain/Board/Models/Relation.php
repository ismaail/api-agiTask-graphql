<?php

declare(strict_types=1);

namespace Domain\Board\Models;

enum Relation: int
{
    case OWNER = 1;
    case GUEST = 2;
}
