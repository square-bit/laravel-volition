<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Casts\Serialize;

/**
 * @property int $id
 * @property class-string $class
 * @property object $payload
 * @property bool $enabled
 */
abstract class Element extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'payload' => Serialize::class,
        'enabled' => 'bool',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function (Element $model): void {
            $model->class = ($model->payload)::class;
        });
    }

    public function disabled(bool $disabled = true): static
    {
        $this->enabled = ! $disabled;

        return $this;
    }
}
