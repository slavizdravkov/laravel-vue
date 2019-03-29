<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question, Request $request)
    {
        $vote = (int) $request->input('vote');

        auth()->user()->voteQuestion($question, $vote);

        return back();
    }
}
