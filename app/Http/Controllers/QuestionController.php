<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show(Question $question) // Se hace un Route Model Binding, osea: un parametro que es una instancia del modelo Question
    // Y se hace una consulta automaticamente para buscar el Question con el id que viene en la URL


    {
        $question->load('answers','category', 'user');

        return view('questions.show', [
            'question' => $question
        ]);
    }
}
