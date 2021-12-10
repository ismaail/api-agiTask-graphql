<?php

namespace App\Exceptions;

use Throwable;
use Rebing\GraphQL\GraphQL;
use GraphQL\Error\Error as GraphqlError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 * Class Handler
 * @package App\Exceptions
 */
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return array[]|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        return $e instanceof GraphqlError
            ? $this->formatGraphqlError($e)
            : parent::render($request, $e);
    }

    /**
     * @param \Throwable|GraphqlError $error
     *
     * @return array
     */
    private function formatGraphqlError(Throwable|GraphqlError $error): array
    {
        return ['errors' => [GraphQL::formatError($error)]];
    }
}
