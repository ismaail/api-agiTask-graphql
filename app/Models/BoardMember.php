<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class BoardMember
 * @package App\Models
 */
class BoardMember extends Pivot
{
    /**#@+
     * @const int
     */
    public const RELATION_OWNER = 1;
    public const RELATION_GUEST = 2;
    /**#@-*/

    /**
     * @var string
     */
    protected $table = 'board_member';
}
