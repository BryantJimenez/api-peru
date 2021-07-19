<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (request()->header('Content-Type')=='application/json' || (isset(explode('/', $request->url())[3]) && explode('/', $request->url())[3]=="api")) {
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json(['status' => 405, 'message' => 'El método especificado en la petición no es valido'], 405);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['status' => 404, 'message' => 'No se han encontrado resultados'], 404);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['status' => 401, 'message' => 'No autenticado'], 401);
            }

            if ($exception instanceof ValidationException) {
                return response()->json(['status' => 422, 'message' => 'Los datos enviados no eran válidos.', 'errors' => $exception->validator->getMessageBag()], 422);
            }
        }

        return parent::render($request, $exception);
    }
}
