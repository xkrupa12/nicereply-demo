<?php

namespace App\Http\Controllers\NiceReply;

use App\Exceptions\APICallFailedException;
use App\Http\Requests\AddRating;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RatingsController extends NiceReplyController
{
    public function index(int $surveyId): View
    {
        try {
            $ratings = $this->client->getRatings($surveyId);
            return view('ratings.index', ['surveyId' => $surveyId, 'ratings' => $ratings]);
        } catch (APICallFailedException) {
            return view('ratings.index', ['surveyId' => $surveyId, 'ratings' => []])
                ->with('error', 'We couldn\'t load your ratings');
        }
    }

    public function create(int $surveyId): View
    {
        return view('ratings.create', ['surveyId' => $surveyId]);
    }

    public function store(AddRating $request): RedirectResponse
    {
        try {
            $this->client->createRating(
                $request->get('survey_id'),
                $request->get('score'),
                $request->get('comment'),
            );
        } catch (APICallFailedException) {
            return redirect()->redirectTo('surveys/' . $request->get('survey_id') . '/ratings')
                ->with('error', 'Failed to submit your rating, please try again later');
        }

        return response()->redirectTo('surveys/' . $request->get('survey_id') . '/ratings')
            ->with('success', 'Thanks for your rating!');
    }
}
