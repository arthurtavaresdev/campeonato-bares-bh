<?php

declare(strict_types=1);

namespace App\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $bar_id
 * @property int $position
 * @property string $score
 * @property Carbon $snapshot_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BarRanking extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'bar_rankings';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'bar_id',
        'position',
        'score',
        'snapshot_date',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'position' => 'integer',
        'snapshot_date' => 'date',
        'score' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bar(): BelongsTo
    {
        return $this->belongsTo(Bar::class);
    }
}
