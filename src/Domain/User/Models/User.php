<?php

declare(strict_types=1);

namespace Domain\User\Models;

use Domain\Board\Models\Board;
use Laravel\Sanctum\HasApiTokens;
use Domain\Board\Models\BoardMember;
use Support\Models\Traits\HasFactory;
use Illuminate\Notifications\Notifiable;
use Domain\User\QueryBuilders\UserQueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function boards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class, 'board_member', 'user_id', 'board_id')
            ->as('membership')
            ->withPivot(['relation'])
            ->using(BoardMember::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [
            //
        ];
    }
}
