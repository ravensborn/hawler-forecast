<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class DomainException extends HttpException
{
    public string $title;

    public string $description;

    public function __construct(
        int $statusCode = 400,
        string $title = 'Error',
        string $description = 'Something went wrong.',
        string $internalMessage = '',
        array $logMetadata = [],
    ) {
        $this->title = $title;
        $this->description = $description;

        parent::__construct(
            statusCode: $statusCode,
            message: $description
        );

        if ($internalMessage) {
            logger()->error($internalMessage, $logMetadata);
        }
    }
}
