<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {
    protected function redirectTo( $request ) {
        throw new AuthenticationException( 'Please login first.' );
    }
}
