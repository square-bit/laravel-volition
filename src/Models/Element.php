<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Casts\Serialize;
use Squarebit\Volition\Traits\BelongToRule;

abstract class Element extends Model
{
    use BelongToRule;

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
