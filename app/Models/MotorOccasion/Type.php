<?php

namespace App\Models\MotorOccasion;

use App\Models\Base\Model;
use Database\Factories\MotorOccasion\TypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $value
 * @property string $brand_id
 *
 * @property-read Brand $brand
 *
 * @method static TypeFactory factory()
 */
class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'brand_id',
    ];

    /**
     * @return BelongsTo<Brand, self>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
