<?php

declare(strict_types=1);

namespace App\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property null|string $place_id
 * @property null|string $address
 * @property null|float $latitude
 * @property null|float $longitude
 * @property string $rating
 * @property int $reviews
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Bar extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'bars';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'name',
        'place_id',
        'address',
        'latitude',
        'longitude',
        'rating',
        'reviews',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'reviews' => 'integer',
        'rating' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function rankings(): HasMany
    {
        return $this->hasMany(BarRanking::class, 'bar_id', 'id');
    }
}
