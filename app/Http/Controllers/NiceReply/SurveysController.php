<?php

namespace App\Http\Controllers\NiceReply;

use App\Exceptions\APICallFailedException;
use Illuminate\View\View;

class SurveysController extends NiceReplyController
{
    public function index(): View
    {
        try {
            return view('surveys.index', ['surveys' => $this->getSurveys()]);
        } catch (APICallFailedException) {
            return view('surveys.index', ['surveys' => []])->with('error', 'We couldn\'t load your surveys');
        }
    }
}
