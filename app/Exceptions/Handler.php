<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
   use ApiResponser;
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
     * @throws \Exception
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
      
        if ($exception instanceof  ValidationException ) {
            return $this->convertValidationExceptionToResponse ( $exception,$request );
        }
        if ($exception instanceof  ModelNotFoundException ) {
            $model =   class_basename( $exception->getModel()) ;
            return $this->errorResponse("No existe informacion con el parámetro indicado en el recurso: {$model} "  , 404);
        }
         if ($exception instanceof  RelationNotFoundException ) {
            return $this->errorResponse("Se ha establecido una relación no existente "  , 500);
        }
        if ($exception instanceof  AuthenticationException ) {
            return $this->errorResponse("No autenticado"  , 401);
        }
        if ($exception instanceof  NotFoundHttpException ) {
            return $this->errorResponse("No se ha encontrado la URL especificada"  , 404);
        }    
        if ($exception instanceof  MethodNotAllowedHttpException ) {
            return $this->errorResponse("Método no permitido."  , 405);
        }        
        if ($exception instanceof  HttpException ) {
            return $this->errorResponse( $exception->getMessage() , $exception->getStatusCode());
        }
        if ($exception instanceof  QueryException ) {
              $errorCode = $exception->errorInfo[1];
              if ( $errorCode == 1451) 
                return $this->errorResponse( 'No es posible borrar el registro porque causaría inconsistencia en la base de datos', 409);
        }   
        if ( config('app.debug')) {
            return parent::render($request, $exception);
        }
        return parent::render($request, $exception);
        return $this->errorResponse('Falla inesperada. Intente luego', 500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
               return $request->expectsJson()
                    ? $this->invalidJson($request, $e)
                    : $this->errorResponse(  $e->getMessage(), 422);;

        //return $this->errorResponse(  $e->getMessage(), 422);
    }


 
}
