<?php

namespace App\Services\NiceReply;

use App\Exceptions\APICallFailedException;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    private const SURVEYS = 'surveys';
    private const RATINGS = 'ratings';

    public function __construct(
        private readonly string $domain,
        private readonly string $user,
        private readonly string $privateKey
    ) {
    }

    /**
     * @throws RuntimeException
     */
    public function getSurveys(): Collection
    {
        $url = $this->domain . '/' . self::SURVEYS;

        $payload = $this->getPayload(Http::withHeaders($this->getHeaders())->get($url));
        return collect($payload['_results']);
    }

    public function getRatings(int $surveyId): Collection
    {
        $url = $this->domain . '/' . self::SURVEYS . '/' . $surveyId . '/' . self::RATINGS;

        $payload = $this->getPayload(Http::withHeaders($this->getHeaders())->get($url));
        return collect($payload['_results']);
    }

    /**
     * @throws APICallFailedException
     */
    public function createRating(int $surveyId, int $score, string $comment): void
    {
        $url = $this->domain . '/' . self::RATINGS;
        $this->getPayload(Http::withHeaders($this->getHeaders())->post($url, [
            'survey_id' => $surveyId,
            'user' => ['username' => $this->user],
            'score' => $score,
            'comment' => $comment,
        ]));
    }

    /**
     * @throws APICallFailedException
     */
    private function getPayload(ClientResponse $response): ?array
    {
        if ($response->status() !== Response::HTTP_OK) {
            $exception = APICallFailedException::withResponse($response);
            Log::error($exception->getMessage(), $exception->getResponsePayload());

            throw $exception;
        }

        return $response->json();
    }

    private function getHeaders(): array
    {
        $credentials = base64_encode(':' . $this->privateKey);
        return [
            'Authorization' => 'Basic ' . $credentials,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}
