<?php

declare(strict_types=1);

namespace App\Models\Ista;

use App\Models\Base\Model;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $usage_id
 * @property string $ista_meter_id
 * @property string $name
 * @property CarbonImmutable $date
 * @property int $usage
 * @property int $usage_previous_year
 */
class Reading extends Model
{
    protected $table = 'ista_readings';

    protected $fillable = [
        'usage_id',
        'ista_meter_id',
        'name',
        'date',
        'usage',
        'usage_previous_year',
    ];

    protected $casts = [
        'date' => 'immutable_date',
    ];

    /**
     * @return BelongsTo<Usage, self>
     */
    public function usage(): BelongsTo
    {
        return $this->belongsTo(Usage::class);
    }
}
