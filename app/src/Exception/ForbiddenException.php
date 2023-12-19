<?php
declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ForbiddenException extends HttpException
{
    public function __construct(string $message = 'Operation forbidden', \Throwable $previous = null, array $headers = [], int $code = 0)
    {
        parent::__construct(Response::HTTP_FORBIDDEN, $message, $previous, $headers, $code);
    }

}