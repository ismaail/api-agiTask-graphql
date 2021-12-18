<?php

declare(strict_types=1);

namespace App\Models;

enum BoardMemberRelation: int
{
    case OWNER = 1;
    case GUEST = 2;
}
