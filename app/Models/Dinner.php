<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Dinner
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $max_guests
 * @property string $start_time
 * @property string $end_time
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Dinner newModelQuery()
 * @method static Builder|Dinner newQuery()
 * @method static Builder|Dinner query()
 * @method static Builder|Dinner whereCreatedAt($value)
 * @method static Builder|Dinner whereDescription($value)
 * @method static Builder|Dinner whereEndTime($value)
 * @method static Builder|Dinner whereId($value)
 * @method static Builder|Dinner whereMaxGuests($value)
 * @method static Builder|Dinner whereStartTime($value)
 * @method static Builder|Dinner whereTitle($value)
 * @method static Builder|Dinner whereUpdatedAt($value)
 * @method static Builder|Dinner whereUserId($value)
 * @mixin Builder
 */
class Dinner extends Model
{

    protected $fillable = [
        'title',
        'description',
        'max_guests',
        'start_time',
        'end_time',
        'user_id'
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'max_guests' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'user_id' => 'integer',
    ];

    use HasFactory;
}
