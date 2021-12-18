<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
     * {@inheritDoc}
     */
    protected static function booted(): void
    {
        static::addGlobalScope(
            'board_member',
            fn(Builder $q) => $q->whereRelation('members', 'id', '=', Auth::user()->id)
        );
    }

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
            ->where('relation', BoardMemberRelation::OWNER)
            ->using(BoardMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buckets(): HasMany
    {
        return $this->hasMany(Bucket::class, 'tenant_id', 'id');
    }
}
