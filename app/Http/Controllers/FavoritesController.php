<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());
        
        return back();
    }

    public function delete(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        return back();
    }
}
