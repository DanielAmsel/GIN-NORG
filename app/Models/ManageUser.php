<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageUser
{
    public function resetPassword(User $user, $newPassword)
    {
        $user->password = Hash::make($newPassword);
        $user->save();
    }
}
