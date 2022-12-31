<?php

declare(strict_types=1);

namespace Domain\Board\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BoardMember extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'board_member';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'relation' => Relation::class,
    ];
}
