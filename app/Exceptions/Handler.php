<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        // Log non-validation exceptions for debugging if needed
        if (!($exception instanceof \Illuminate\Validation\ValidationException)) {
            $logPath = public_path('error_log_debug.txt');
            $data = date('Y-m-d H:i:s') . "\n";
            $data .= "URL: " . $request->fullUrl() . "\n";
            $data .= "Exception: " . $exception->getMessage() . "\n";
            $data .= "File: " . $exception->getFile() . " on line " . $exception->getLine() . "\n";
            $data .= "Trace:\n" . $exception->getTraceAsString() . "\n";
            $data .= "--------------------------------------------------\n\n";
            @file_put_contents($logPath, $data, FILE_APPEND);
        }

        return parent::render($request, $exception);
    }
}
