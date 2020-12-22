<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\DinnerInvite
 *
 * @property int $id
 * @property int $dinner_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Dinner[] $dinners
 * @property-read int|null $dinners_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|DinnerInvite newModelQuery()
 * @method static Builder|DinnerInvite newQuery()
 * @method static Builder|DinnerInvite query()
 * @method static Builder|DinnerInvite whereCreatedAt($value)
 * @method static Builder|DinnerInvite whereDinnerId($value)
 * @method static Builder|DinnerInvite whereId($value)
 * @method static Builder|DinnerInvite whereUpdatedAt($value)
 * @method static Builder|DinnerInvite whereUserId($value)
 * @mixin Builder
 */
class DinnerInvite extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->morphedByMany(User::class, 'inviteable');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function dinners()
    {
        return $this->morphedByMany(Dinner::class, 'inviteable');
    }

}
