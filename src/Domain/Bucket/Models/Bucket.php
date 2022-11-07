<?php

declare(strict_types=1);

namespace Domain\Bucket\Models;

use Domain\Board\Models\Board;
use Domain\Tenant\Models\HasTenant;
use Support\Models\Traits\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Bucket
 * @package App\Models
 */
class Bucket extends Model
{
    use HasFactory;
    use HasTenant;

    /**
     * @var string
     */
    protected $table = 'buckets';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'archived',
        'is_sprint',
        'starts_at',
        'ends_at',
    ];

    /**
     * @var array<string,string>
     */
    protected $casts = [
        'archived' => 'boolean',
        'is_sprint' => 'boolean',
        'starts_at' => 'immutable_datetime',
        'ends_at' => 'immutable_datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'tenant_id', 'id');
    }
}
