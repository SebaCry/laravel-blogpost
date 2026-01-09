<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show(Question $question) // Se hace un Route Model Binding, osea: un parametro que es una instancia del modelo Question
    // Y se hace una consulta automaticamente para buscar el Question con el id que viene en la URL

    {
        $userId = auth()->id();

        $question->load([
            'user',
            'category',

            'answers' => fn ($query) => $query->with([
                'user',
                'hearts' => fn ($query) => $query->where('user_id', $userId),
                'comments' => fn ($query) => $query->with([
                    'user',
                    'hearts' => fn ($query) => $query->where('user_id', $userId),
                ]),
            ]),

            'comments' => fn ($query) => $query->with([
                'user',
                'hearts' => fn ($query) => $query->where('user_id', $userId),
            ]),

            'hearts' => fn ($query) => $query->where('user_id', $userId)
        ]);

        return view('questions.show', [
            'question' => $question
        ]);
    }

    public function index()
    {
        $questions = Question::with([
            'user',
            'category'
        ])->latest()
        ->paginate(24);

        return view('questions.index', [
            'questions' => $questions
        ]);
    }

    public function destroy(Question $question)
    {

        $question->delete;

        return redirect()->route('home');
    }

    public function create()
    {
        $categories = Category::all();

        return view('questions.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $question = Question::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('questions.show', $question);

    }

    public function edit(Question $question)
    {
        $categories = Category::all();

        return view('questions.edit', [
            'question' => $question,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $question->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('questions.show', $question);
    }
}
