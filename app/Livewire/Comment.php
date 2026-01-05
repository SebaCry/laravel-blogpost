<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Comment extends Component
{
    public Model $commentable;
    public bool $showForm = false;
    public string $content = '';

    public function toggle()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.comment', [
            'comments' => $this->commentable->comments,
        ]);
    }

    public function add()
    {
        $data = $this->validate([
            'content' => 'required|string|max:255'
        ]);

        $this->commentable->comments()->create([
            'content' => $data['content'],
            'user_id' => 20,
        ]);

        $this->reset('content', 'showForm');
    }
}
