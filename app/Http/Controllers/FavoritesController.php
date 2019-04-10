<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Question $question, Request $request)
    {
        $question->favorites()->attach(auth()->id());

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return back();
    }

    public function delete(Question $question, Request $request)
    {
        $question->favorites()->detach(auth()->id());

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return back();
    }
}
