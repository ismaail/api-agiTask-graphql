<?php

declare(strict_types=1);

namespace Domain\Board\Models;

enum BoardMemberRelation: int
{
    case OWNER = 1;
    case GUEST = 2;
}
