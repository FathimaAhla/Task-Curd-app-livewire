<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class Posts extends Component
{
    public $title,$body;
    public $posts;
    public $edit_mode=false;
    public $post_id;

    public function store(){
        $validate_data = $this->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        Post::create($validate_data);

        session()->flash('message','Post created Successfully');
        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->title = '';
        $this->body = '';
    }

    public function edit($id){
        $this->edit_mode = true;
        $post = Post::find($id);
        $this->title = $post->title;
        $this->body = $post->body;
        $this->post_id = $id;
    }

    public function update(){
        $validate_data = $this->validate([
            'title'=>'required',
            'body'=>'required'
        ]);

        $post = Post::find($this->post_id);
        $post->update($validate_data);

        session()->flash('message','Post Updated Successfully');
        $this->resetInputFields();
        $this->edit_mode = false;

    }
    public function cancelUpdate(){
        $this->edit_mode = false;
        $this->resetInputFields();
    }

    public function delete($id){
        $post = Post::find($id);
        $post->delete();
    }

    public function render()
    {
        $this->posts = Post::all();
        return view('livewire.posts');
    }
}
