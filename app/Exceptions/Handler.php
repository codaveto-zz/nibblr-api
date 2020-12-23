<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {
        $this->renderable( function ( ValidationException $e, $request ) {
            $code = 422;
            return response( [
                'status'  => 'failed',
                'code'=> $code,
                'message' => 'One or more fields failed validation.',
                'errors'  => $e->errors()
            ], $code );
        } );
        $this->renderable( function ( AuthenticationException $e, $request ) {
            $code = 401;
            return response( [
                'status'  => 'failed',
                'code'=> $code,
                'message' => $e->getMessage(),
            ], $code );
        } );
        $this->renderable( function ( NotFoundHttpException $e, $request ) {
            $code = 404;
            return response( [
                'status'  => 'failed',
                'code'=> $code,
                'message' => $e->getMessage(),
            ], $code );
        } );
    }
}
