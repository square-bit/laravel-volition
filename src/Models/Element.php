<?php

namespace Squarebit\Volition\Models;

use Illuminate\Database\Eloquent\Model;
use Squarebit\Volition\Casts\PayloadCast;

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
        'payload' => PayloadCast::class,
        'enabled' => 'bool',
    ];

    public function disabled(bool $disabled = true): static
    {
        $this->enabled = ! $disabled;

        return $this;
    }
}
