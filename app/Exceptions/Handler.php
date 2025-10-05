<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        
    }

    public function render($request, Throwable $exception)
    {
        return response()->json([
            'status' => false,
            'message' => 'Recurso não encontrado',
            'error_type' => class_basename($exception)
        ], 404);
    }
}
