<?php

declare(strict_types=1);

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MongoDB\Laravel\Eloquent\Model as MongodbModel;

/**
 * @property-read string $id
 * @property-read string $_id
 *
 * @method static create(array $array)
 * @method static updateOrCreate(array $filters, array $values)
 * @method static upsert(array $values, array $identifiers)
 * @method static insert(mixed $data)
 * @method static find(string $id)
 * @method static findOrFail(string $id)
 * @method static findOr(string $id, callable $closure)
 * @method static where(... $params)
 * @method static whereIn(string $column, array $values)
 * @method static whereNotIn(string $column, array $values)
 * @method static whereBetween(string $column, array $values)
 * @method static withCount(string $relation)
 * @method static select(array $array)
 * @method static count()
 * @method static first()
 * @method static firstOrFail()
 * @method static truncate()
 * @method bool trashed()
 * @method static make(array $attributes)
 * @method static cursor()
 * @method static Collection raw(mixed $closure)
 */
class Model extends MongodbModel
{
    public static function findByRouteKey(string $routeKey): ?self
    {
        $model = self::find(route_key_to_id($routeKey));

        if (! $model instanceof self) {
            return null;
        }

        return $model;
    }

    public static function findOrFailByRouteKey(string $routeKey): self
    {
        $model = self::find(route_key_to_id($routeKey));

        if (! $model instanceof self) {
            throw new ModelNotFoundException();
        }

        return $model;
    }

    public function getRouteKey(): string
    {
        if (! is_string($this->id)) {
            return '';
        }

        return id_to_route_key($this->id);
    }
}
