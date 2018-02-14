<?php namespace App\Http\Controllers;
use App\Posts;
use App\Comments;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $slug = $request->input('slug');
        $comment = new Comments([
            'from_user' => $request->user()->id,
            'on_post' => $request->input('on_post'),
            'body' => $request->input('body')
        ]);

        $post = Posts::find($request->input('on_post'));
        $post = $post->comments()->save($comment);
        return redirect($slug)->with('message', 'Comment published');

    }
}
