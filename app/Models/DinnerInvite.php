<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
