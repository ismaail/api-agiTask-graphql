<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use Rebing\GraphQL\GraphQL;
use GraphQL\Error\Error as GraphqlError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
