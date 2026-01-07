<?php

namespace App\Models;

use App\Models\Comment;
use App\Traits\HasHeart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, HasHeart;

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

    protected static function booted()
    {
        static::deleting(function ($question) {
            $question->hearts()->delete();

            $question->comments()->get()->each(function ($comment) {
                $comment->hearts()->delete();
                $comment->delete();
            });

            $question->answers()->get()->each(function ($answer) {
                $answer->hearts()->delete();

                $answer->comments()->get()->each(function ($comment) {
                    $comment->hearts()->delete();

                    $comment->delete();
                });
            });
        });
    }
}
