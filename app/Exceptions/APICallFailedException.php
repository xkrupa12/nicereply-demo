<?php

namespace App\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class APICallFailedException extends RuntimeException
{
    protected $message = 'API Call failed';

    protected ?Response $response;

    public static function withResponse(Response $response = null): self
    {
        $self = new self();
        $self->response = $response;
        return $self;
    }

    public function getResponsePayload(): array
    {
        return $this->response->json();
    }
}
