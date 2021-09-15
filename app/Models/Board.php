<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Board
 * @package App\Models
 */
class Board extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'boards';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'archived' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->as('membership')
            ->withPivot(['relation'])
            ->using(BoardMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owner()
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->where('relation', BoardMember::RELATION_OWNER)
            ->using(BoardMember::class);
    }
}
