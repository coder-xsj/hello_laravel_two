<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user){
        return $currentUser->id == $user->id;
    }

    public function destroy(User $currentUser, User $user){
        // 是管理员，然后不是自己就可以删除
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
