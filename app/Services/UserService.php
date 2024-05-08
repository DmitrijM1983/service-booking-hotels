<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @param int $id
     * @return bool
     */
    public static function is_admin(int $id): bool
    {
        $user = User::find($id);
        if($user->role === 'admin') {
            return true;
        }
        return false;
    }
}
