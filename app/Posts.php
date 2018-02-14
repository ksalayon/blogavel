<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Posts extends Eloquent {

    const PUBLISHED = 1;
    const DRAFT = 0;

    protected $connection = 'mongodb';
    //restricts columns from modifying
    protected $guarded = [];
    // posts has many comments
    // returns all comments on that post
    public function comments()
    {
        return $this->embedsMany('App\Comments');
    }
    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\User','author_id');
    }

    public static function getAllByUser($userId, $published = NULL)
    {
        $operatorActive = '=';
        $valueActive = $published;
        if($published === NULL){
            $operatorActive = '<=';
            $valueActive = 1;
        } else {
            $operatorActive = '=';
            $valueActive = $published;
        }

        return self::where('author_id',(int)$userId)
            ->where('active', $operatorActive, $valueActive)
            ->orderBy('created_at','desc')
            ->paginate(5);
    }


}
