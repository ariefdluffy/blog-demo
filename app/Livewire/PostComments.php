<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PostComments extends Component
{
    use WithPagination;
    public Post $post;

    #[Rule('required|min:3|max:150')]
    public string $comment;

    // #[Rule('required|min:3|max:150')]
    // public Comment $feedback;

    public function postComment() {

        if(auth()->guest())
        {
            return;
        }
        $this->validateOnly('comment');

        $this->post->comments()->create([
            'comment'=> $this->comment,
            'user_id' => auth()->id()
        ]);
        $this->reset('comment');
    }

    #[Computed()]
    public function comments() {
        // return $this?->post?->comments()->latest()->paginate(5);
        return $this?->post?->comments()->with('user')->latest()->paginate(5);
    }

    public function render()
    {
        return view('livewire.post-comments');
    }
}
