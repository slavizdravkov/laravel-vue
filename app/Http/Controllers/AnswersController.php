<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    /**
     * @param Question $question
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $question->answers()->create(['body' => $request->input('body'), 'user_id' => Auth::id()]);

        return back()->with('success', 'Your answer has been submitted successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Answer  $answer
     * @param Question $question
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        return view('answers.edit', [
            'question' => $question,
            'answer' => $answer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been updated',
                'body_html' => $answer->getBodyHtmlAttribute()
            ]);
        }

        return redirect()
            ->route('questions.show', $question->slug)
            ->with('success', 'Your answer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @param Answer $answer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Question $question, Answer $answer, Request $request)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Your answer has been removed'
            ]);
        }

        return back()->with('success', 'Your answer has been removed');
    }
}
