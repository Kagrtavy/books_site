<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chapter;

class ChapterPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function delete(User $user, Chapter $chapter): bool
    {
        return $user->id === $chapter->publication->user_id;
    }
}
