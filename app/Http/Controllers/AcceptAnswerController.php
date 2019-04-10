<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer, Request $request)
    {
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'You have accept this answer as best answer'
            ]);
        }

        return back();
    }
}
