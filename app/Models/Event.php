<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Event
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $title
 * @property string $sub_title
 * @property array  $frequency
 * @property string $owner_id
 * @property string $description
 * @property array  $meta
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Event extends Model
{
    protected $casts = [
        'meta'      => 'array',
        'frequency' => 'array',
    ];

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'frequency',
        'meta',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewed');
    }
}
