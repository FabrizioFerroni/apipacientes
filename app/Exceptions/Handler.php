<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception){
        return response()->json([
            'respuesta' => __('Los datos proporcionados no son válidos.'),
            'errores' => $exception->errors(),
        ], $exception->status);
    }

    public function render($request, Throwable $exception){
        if($exception instanceof ModelNotFoundException){
            return response()->json([
                "respuesta" => false,
                "error" => "Error no se encontro ningun dato con ese identificador"
            ], 400);
        }

        if($exception instanceof RouteNotFoundException){
            return response()->json([
                "respuesta" => false,
                "error" => "No tenes permiso para ingresar a esta ruta"
            ], 401);
        }
        return parent::render($request, $exception);
    }

}
