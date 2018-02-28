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
        $data = $this->__parseRequest($request);
        $res = Comments::store($data);

        if($res !== true){
            return redirect($data['Comment']['slug'])->with('message', $res);
        }

        return redirect($data['Comment']['slug'])->with('message', 'Comment published');

    }

    private function __parseRequest(Request $request){

        $data['Comment']['slug'] = $request->input('slug');
        $data['Comment']['from_user'] = $request->user()->id;
        $data['Comment']['on_post'] = $request->input('on_post');
        $data['Comment']['body'] = $request->input('body');

        return $data;
    }
}
