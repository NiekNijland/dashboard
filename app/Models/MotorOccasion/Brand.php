<?php

namespace App\Models\MotorOccasion;

use App\Models\Base\Model;
use Database\Factories\MotorOccasion\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $value
 * @property string $name
 *
 * @method static BrandFactory factory()
 */

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'name',
    ];

    /**
     * @return HasMany<Type>
     */
    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }
}
