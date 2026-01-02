<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class); // Question <- Categoria
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Question <- User
    }

    public function answers()
    {
        return $this->hasMany(Answer::class); // Question -> Answer
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable'); // able
    }
}
