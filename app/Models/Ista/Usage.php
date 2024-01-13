<?php

declare(strict_types=1);

namespace App\Models\Ista;

use App\Models\Base\Model;
use Carbon\CarbonImmutable;

/**
 * @property string $ista_id
 * @property CarbonImmutable $date
 * @property int $usage
 * @property int $usage_previous_year
 * @property int $building_average_usage
 * @property CarbonImmutable $period_start
 * @property CarbonImmutable $period_end
 */
class Usage extends Model
{
    protected $table = 'ista_usages';

    protected $fillable = [
        'ista_id',
        'date',
        'usage',
        'usage_previous_year',
        'building_average_usage',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'date' => 'immutable_date',
        'period_start' => 'immutable_date',
        'period_end' => 'immutable_date',
    ];
}
