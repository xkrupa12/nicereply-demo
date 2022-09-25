<?php

namespace Tests\Feature\NiceReply;

use App\Services\NiceReply\Client;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RatingsTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        $domain = 'https://nice-reply.test/v1';
        $this->app->instance(Client::class, new Client($domain, 'test-user', 'private'));
    }

    /**
     * @test
     */
    public function it_displays_ratings_for_survey(): void
    {
        $ratings = [
            [
                'id' => 1,
                'score' => 5,
                'comment' => 'Testing comment #1',
                'survey' => [
                    'id' => 1,
                    'metric' => 'CSAT',
                ],
                'user' => [],
            ],
            [
                'id' => 2,
                'score' => 3,
                'comment' => 'Testing comment #2',
                'survey' => [
                    'id' => 1,
                    'metric' => 'CSAT',
                ],
                'user' => [],
            ],
        ];

        Http::fake([
            'https://nice-reply.test/v1/surveys/1/ratings' => Http::response(['_results' => $ratings]),
        ]);

        $response = $this->get('/surveys/1/ratings');
        $response->assertSuccessful();
        $response->assertSee('Ratings (Survey 1)');
        array_map(static fn (array $rating) => $response->assertSee($rating['comment']), $ratings);
    }

    /**
     * @test
     */
    public function it_shows_rating_creation_form(): void
    {
        $response = $this->get('/surveys/1/ratings/create');
        $response->assertSuccessful();
        $response->assertSee('Create new rating (Survey 1)');
    }
}
