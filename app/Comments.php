<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Posts;

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


    public static function getAllByUser($userId, $take = 5)
    {
        $comments = self::where('from_user',(int)$userId)
            ->orderBy('created_at','desc')
            ->take($take)
            ->get();
        return $comments;

        // $comments = self::where('from_user',(int)$userId)
        //     ->orderBy('created_at','desc')
        //     ->take($take)
        //     ->get();
        // $data['comments'] = [];
        //
        //
        // foreach($comments as $key => $val){
        //     $data['comments'][$key] = $val;
        //     $data['comments'][$key]['posts'] = Posts::find($val->on_post);
        // }
        //
        //
        // return $data;
    }
}
