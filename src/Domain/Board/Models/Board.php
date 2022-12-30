<?php

declare(strict_types=1);

namespace Domain\Board\Models;

use Domain\User\Models\User;
use Domain\Bucket\Models\Bucket;
use Illuminate\Support\Facades\Auth;
use Support\Models\Traits\HasFactory;
use Support\Tenant\Models\TenantModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Board extends Model implements TenantModel
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'boards';

    /**
     * @var array<int, string>
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

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->as('membership')
            ->withPivot(['relation'])
            ->using(BoardMember::class);
    }

    public function owner(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_member', 'board_id', 'user_id')
            ->where('relation', BoardMemberRelation::OWNER)
            ->using(BoardMember::class);
    }

    public function buckets(): HasMany
    {
        return $this->hasMany(Bucket::class, 'board_id', 'id');
    }

    public function getTenantId(): int
    {
        return $this->getAttribute('id');
    }
}
