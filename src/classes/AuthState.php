<?php

namespace Quantic\SessionOut\classes;

use Quantic\SessionOut\Events\AuthSessionBegins;
use Auth;

class AuthState
{
    /**
     * broadcast user auth session available
     */
    public static function sessionAvailable()
    {
        broadcast(new AuthSessionBegins(Auth::id()));
    }
}
