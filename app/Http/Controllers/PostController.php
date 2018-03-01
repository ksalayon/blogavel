<?php namespace App\Http\Controllers;
use App\Posts;
use App\User;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        //fetch 5 posts from database which are active and latest
        $posts = Posts::where('active',1)->orderBy('created_at','desc')->paginate(5);
        //page heading
        $title = 'Latest Posts';
        //return home.blade.php template from resources/views folder
        return view('home')->withPosts($posts)->withTitle($title);
    }

    public function create(Request $request)
    {
        // if user can post i.e. user is admin or author
        if($request->user()->can_post()) {
            return view('posts.create');
        } else {
            return redirect('/')->withErrors('You do not have sufficient permissions for writing post.');
        }
    }

    public function store(PostFormRequest $request)
    {
        $data = $this->__parseRequest($request);

        $message = ($data['active'] === 1) ? 'Post published successfully'
            : 'Post saved successfully';

        try {
            Posts::store($data);
        } catch(Exception $e) {
            return redirect('edit/'. $data['slug'])->withMessage($e->getMessage());
        }

        return redirect('edit/'. $data['slug'])->withMessage($message);

    }

    public function show($slug)
    {
        $post = Posts::where('slug',$slug)->first();
        if(!$post) {
            return redirect('/')->withErrors('requested page not found');
        }

        $comments = $post->comments;
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    public function edit(Request $request, $slug)
    {
        $post = Posts::where('slug',$slug)->first();
        if($post && (Auth::id() == $post->author_id || $request->user()->is_admin())) {
            return view('posts.edit')->with('post',$post);
        } else {
            return redirect('/')->withErrors('You do not have permission to edit this post.');
        }
    }

    public function update(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Posts::find($post_id);
        if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {

            $data = $this->__parseRequest($request, $post);
            $landing = $post->slug;
            $message = ($data['active'] === 1) ? 'Post published successfully'
                : 'Post updated successfully';

            try {
                $post->upd($data);
            } catch (Exception $e) {
                $message = $e->getMessage();
                $landing = 'edit/' . $post->slug;

                return redirect($landing)->withErrors($message)->withInput(
                    $request->except('post_id')
                );
            }

            return redirect($landing)->withMessage($message);
        } else {
            return redirect('/')->withErrors('you do not have permissions to update this post.');
        }
    }

    public function destroy(Request $request, $id)
    {
        $post = Posts::find($id);
        if($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';
        }
        else {
            $data['errors'] = 'Invalid Operation. You do not have permissions to delete this post';
        }
        return redirect('/')->with($data);
    }

    private function __parseRequest($request, Posts $post = null)
    {

        $data['title'] = ($request->get('title')) ?? $request->input('title');
        $data['body'] = ($request->get('body')) ?? $request->input('body');
        $data['slug'] = str_slug($data['title']);
        if($post === NULL || empty($post->id)) {
            $data['author_id'] = Auth::id();
        }
        $data['active'] = ($request->has('save')) ? 0 : 1;
        return $data;
    }
}
