<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;

    // public $comments;

    public $newComment;

    // public function mount()
    // {
    //     $initialcomments = Comment::latest()->get();

    //     $this->comments = $initialcomments;
    // }

    public $image;

    public $ticketId = 0;

    protected $listeners = [
        'fileUpload'     => 'handleFileUpload',
        'ticketSelected' => 'ticketSelected'
    ];


    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => 'required|max:255']);
    }

    public function AddComment()
    {
        $this->validate(['newComment' => 'required|max:255']);

       $upload_image = $this->storeImage();

        $createdComment = Comment::create([
            'body'    => $this->newComment,
            'user_id' => 1,
            'image'   => $upload_image,
            'support_ticket_id'   => $this->ticketId,
        ]);

        //$this->comments->prepend($createdComment);

        $this->newComment ="";
        $this->image      ="";

        session()->flash('message', 'Comment Added Successfully.');
    }

    public function storeImage()
    {
        if(!$this->image) {

            return null;
        }

        $img = ImageManagerStatic::make($this->image)->encode('jpg');

        $name = Str::random().'.jpg';

        Storage::disk('public')->put($name, $img);

        return $name;
    }

    public function remove($comment_id)
    {
        $comment = Comment::find($comment_id);

        if($comment->image){

            Storage::disk('public')->delete($comment->image);
        }

        $comment->delete();

        //$this->comments = $this->comments->except($comment_id);

        session()->flash('message', 'Comment Deleted Successfully.');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => Comment::where('support_ticket_id', $this->ticketId)->latest()->paginate(5)
        ]);
    }
}
