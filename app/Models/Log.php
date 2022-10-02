<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Log extends Model
{
    use Prunable;

    protected $guarded = ['id'];
    protected $casts = ['context' => 'array'];

    public function trace(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value ? explode("\n", $value): null,
            set: fn($value) => $value ? implode("\n", $value) : null
        );
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(5));
    }
}
