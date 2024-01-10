<?php

declare(strict_types=1);

namespace App\Models\Ista;

use App\Models\Base\Model;
use Carbon\CarbonImmutable;

/**
 * @property string $ista_id
 * @property CarbonImmutable $date
 * @property int $usage
 */
class Usage extends Model
{
    protected $table = 'ista_usages';

    protected $fillable = [
        'ista_id',
        'date',
        'usage',
        'period_start',
        'period_end',
    ];

    protected $casts = [
        'date' => 'immutable_date',
        'period_start' => 'immutable_date',
        'period_end' => 'immutable_date',
    ];
}
