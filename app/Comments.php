<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Posts;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class Comments extends Eloquent {
    protected $connection = 'mongodb';
    //comments table in database
    protected $guarded = [];
    // user who has commented
    public function author()
    {
        return $this->belongsTo('App\User','from_user');
    }
    // returns post of any comment
    public function post()
    {
        return $this->belongsTo('App\Posts','on_post');
    }

    public static function store($data)
    {
        try{
            $comment = new Comments([
                'from_user' => $data['Comment']['from_user'],
                'on_post' => $data['Comment']['on_post'],
                'body' => $data['Comment']['body'],
                'slug' => $data['Comment']['slug']
            ]);
            $post = Posts::find($data['Comment']['on_post']);
            $post = $post->comments()->save($comment);
            return true;
        } catch(Exception $e){
            return $e->getMessage();
        }


    }

    public static function getAllByUser($userId, $take = 3)
    {
        $qPosts = Posts::where('comments.from_user', '=', (int)$userId)
            ->where('active', '=', 1)
            ->select('title', 'slug', 'comments')
            ->orderBy('created_at','desc')
            ->paginate($take);

        $posts = [];
        foreach($qPosts as $pKey => $pVal){

            $comments = $pVal->comments()->map(function ($value, $key) use ($userId) {
                if($value->from_user == $userId){
                    return [
                        'body' => $value->body,
                        'created_at' => $value->created_at,
                        'from_user' => $value->from_user,
                    ];
                }
            });

            $tmpPost['_id'] = $pVal->_id;
            $tmpPost['title'] = $pVal->title;
            $tmpPost['slug'] = $pVal->slug;
            $tmpPost['comments'] = [];
            if(!empty($comments)){
                foreach($comments as $cKey => $cVal){
                    if(!empty($cVal) && $cVal !== NULL){
                        array_push($tmpPost['comments'], $cVal);
                    }
                }
            }

            array_push($posts, $tmpPost);
        }

        $postsCollection = collect($posts);

        return $postsCollection;
    }
}
