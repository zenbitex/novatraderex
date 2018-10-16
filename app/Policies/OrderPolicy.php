<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Xchange;
use Illuminate\Auth\Access\HandlesAuthorization;
class OrderPolicy
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



    public function cancel(User $user,Xchange $xchange)
    {
        return $user->id === $xchange->user_id;
    }
}
