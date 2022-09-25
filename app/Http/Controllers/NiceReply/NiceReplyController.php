<?php

namespace App\Http\Controllers\NiceReply;

use App\Services\NiceReply\Client;
use Illuminate\Support\Collection;

abstract class NiceReplyController
{
    public function __construct(protected readonly Client $client)
    {
    }

    protected function getSurveys(): Collection
    {
        return $this->client->getSurveys();
    }
}
