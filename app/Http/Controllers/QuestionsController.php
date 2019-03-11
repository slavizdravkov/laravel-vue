<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Question $question
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        $questions = $question->with('user')->latest()->paginate(5);

        return view('questions.index', ['questions' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create', ['question' => $question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AskQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $user = Auth::user();
        if (!$user) {
            redirect()->back();
        }

        $question = new Question([
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ]);

        $user->questions()->save($question);

        return redirect()->route('questions.index')->with('success', 'Your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
