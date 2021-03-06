<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Posts;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller {
    /*
    * Display active posts of a particular user
    *
    * @param int $id
    * @return view
    */

    public function user_posts($id)
    {
        $posts = Posts::getAllByUser($id, Posts::PUBLISHED);
        $title = User::find($id)->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    /*
    * Display all of the posts of a particular user
    *
    * @param Request $request
    * @return view
    */
    public function user_posts_all(Request $request)
    {
        $user = $request->user();
        $posts = Posts::getAllByUser($user->id);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    /*
    * Display draft posts of a currently active user
    *
    * @param Request $request
    * @return view
    */
    public function user_posts_draft(Request $request)
    {
        //
        $user = $request->user();
        $posts = Posts::where('author_id',$user->id)->where('active',0)->orderBy('created_at','desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }
    /**
    * profile for user
    */
    public function profile(Request $request, $id)
    {
        $data['user'] = User::find($id);

        try {
            if (!$data['user']) {
                return redirect('/');
            }

            $profile = $data['user']->getProfile();

        } catch (Exception $e) {
            return redirect('/')->withErrors($e->getMessage());
        }

        $data = array_merge($data, $profile);

        if ($request->user() && $data['user']->id == $request->user()->id) {
            $data['author'] = true;
        } else {
            $data['author'] = null;
        }

        return view('admin.profile', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
