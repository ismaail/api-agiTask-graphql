<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bucket
 * @package App\Models
 */
class Bucket extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'buckets';

    /**
     * @var string[]
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
     * @var string[]
     */
    protected $dates = [
        'starts_at',
        'ends_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'tenant_id', 'id');
    }
}
