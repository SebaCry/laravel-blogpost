<?php

namespace App\Traits;

use App\Models\Heart;
use Illuminate\Support\Facades\Auth;

trait HasHeart
{
    public function hearts()
    {
        return $this->morphMany(Heart::class, 'heartable')  ; // able
    }

    public function isHearted()
    {
        if ($this->relationLoaded('hearts')) {
            return $this->hearts->isNotEmpty();
        }
        return $this->hearts()->where('user_id', Auth::id())->exists();
    }

    public function heart()
    {
        $this->hearts()->create([
            'user_id' => Auth::id(),
        ]);
    }

    public function unheart()
    {
        $this->hearts()->where('user_id', Auth::id())->delete();
    }
}
