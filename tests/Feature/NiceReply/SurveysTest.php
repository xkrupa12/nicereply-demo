<?php

namespace Tests\Feature\NiceReply;

use App\Services\NiceReply\Client;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SurveysTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $domain = 'https://nice-reply.test/v1';
        $this->app->instance(Client::class, new Client($domain, 'test-user', 'private'));
    }

    /**
     * @test
     */
    public function it_loads_and_displays_surveys(): void
    {
        $surveys = [
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

        Http::fake([
            'https://nice-reply.test/v1/surveys' => Http::response(['_results' => $surveys]),
        ]);

        $response = $this->get('/surveys');
        $response->assertSuccessful();
        $response->assertSee('Surveys list');

        array_map(static fn (array $survey) => $response->assertSee($survey['name']) , $surveys);
    }
}

