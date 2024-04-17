<?php

namespace App\Models\MotorOccasion;

use App\Models\Base\Model;

/**
 * @property string $name
 */
class Seller extends Model
{
    protected $fillable = [
        'name',
        'province',
        'city',
    ];
}
