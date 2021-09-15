<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'archived'
    ];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'archived' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->as('membership')
            ->withPivot(['relation'])
            ->using(BoardMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owner(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->where('relation', BoardMember::RELATION_OWNER)
            ->using(BoardMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buckets(): HasMany
    {
        return $this->hasMany(Bucket::class, 'board_id', 'id');
    }
}
