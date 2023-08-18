<?php

namespace Squarebit\Volition\Models;

use classObj;
use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Casts\Serialize;
use Squarebit\Volition\Traits\BelongToRule;

/**
 * @property int $id
 * @property class-string $class
 * @property classObj $payload
 */
abstract class Element extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'payload' => Serialize::class,
    ];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function (Element $model): void {
            $model->class = ($model->payload)::class;
        });
    }
}
