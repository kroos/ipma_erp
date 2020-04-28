<?php

namespace App\Providers\Custom;

use Illuminate\Support\ServiceProvider;

// using this to override Illuminate\Auth\EloquentUserProvider

// what to override
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Str;

// class AccountUserProvider extends ServiceProvider
class EloquentUserProvider extends UserProvider
{

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        // this is for plain text user password
        // dd($plain, $user->getAuthPassword());
        if ($plain == $user->getAuthPassword()) {
            return true;
        } else {
            return false;
        }
        // return $this->hasher->check($plain, $user->getAuthPassword());
    }

}
