<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer, Request $request)
    {
        $vote = $request->input('vote');

        auth()->user()->voteAnswer($answer, $vote);

        return back();
    }
}
