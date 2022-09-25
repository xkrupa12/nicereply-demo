<?php

namespace Tests\Unit\Services\NiceReply;

use App\Exceptions\APICallFailedException;
use App\Services\NiceReply\Client;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClientTest extends TestCase
{
    private const SURVEYS = [
        [
            'id' => 1,
            'name' => 'Test Survey#1',
            'metric' => 'CSAT',
            'question' => 'Testing question #1',
            'score' => 5,
        ],
        [
            'id' => 2,
            'name' => 'Test Survey#2',
            'metric' => 'NPS',
            'question' => 'Testing question #2',
            'score' => 3,
        ],
    ];
    private const RATINGS = [
        [
            'id' => 1,
            'score' => 5,
            'comment' => 'Comment#1',
            'survey' => [
                'id' => 1,
                'type' => 'CSAT',
            ],
            'customer' => null,
            'user' => [
                'username' => 'test-user-1',
            ],
        ],
        [
            'id' => 2,
            'score' => 4,
            'comment' => 'Comment#2',
            'survey' => [
                'id' => 1,
                'type' => 'CSAT',
            ],
            'customer' => null,
            'user' => [
                'username' => 'test-user-2',
            ],
        ],
    ];

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

        $domain = 'https://nice-reply.test/v1';
        $this->client = new Client($domain, 'test-user', 'private');
    }

    /**
     * @test
     */
    public function it_can_load_surveys(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/surveys' => Http::response(['_results' => self::SURVEYS]),
        ]);

        $surveys = $this->client->getSurveys();

        $this->assertCount(count(self::SURVEYS), $surveys);

        $surveys = $surveys->keyBy('id');
        array_map(function (array $expected) use ($surveys) {
            $this->assertTrue($surveys->has($expected['id']));
            $this->assertEquals($expected, $surveys->get($expected['id']));
        }, self::SURVEYS);
    }

    /**
     * @test
     */
    public function it_raises_api_exception_if_survey_loading_fails(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/surveys' => Http::response(['errors' => ['Something went wrong']], 500),
        ]);

        $this->expectException(APICallFailedException::class);
        $this->client->getSurveys();
    }

    /**
     * @test
     */
    public function it_can_load_ratings(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/surveys/1/ratings' => Http::response(['_results' => self::RATINGS]),
        ]);

        $ratings = $this->client->getRatings(1);

        $this->assertCount(count(self::RATINGS), $ratings);

        $ratings = $ratings->keyBy('id');
        array_map(function (array $expected) use ($ratings) {
            $this->assertTrue($ratings->has($expected['id']));
            $this->assertEquals($expected, $ratings->get($expected['id']));
        }, self::RATINGS);
    }

    /**
     * @test
     */
    public function it_raises_api_exception_if_ratings_loading_fails(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/surveys/1/ratings' => Http::response(['errors' => ['Something went wrong']], 500),
        ]);

        $this->expectException(APICallFailedException::class);
        $this->client->getRatings(1);
    }

    /**
     * @test
     */
    public function it_can_store_new_rating(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/ratings' => Http::response(['_results' => ['id' => 1, 'score' => 5]]),
        ]);

        $this->client->createRating(1, 5, 'Testing Comment');

        Http::assertSent(function (Request $request) {
            return strtolower($request->method()) === 'post';
        });
    }

    /**
     * @test
     */
    public function it_raises_api_exception_if_rating_creation_fails(): void
    {
        Http::fake([
            'https://nice-reply.test/v1/ratings' => Http::response(['errors' => ['Something went wrong']], 500),
        ]);

        $this->expectException(APICallFailedException::class);
        $this->client->createRating(1, 5, 'Testing Comment');
    }
}
