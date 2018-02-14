<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Posts extends Eloquent {

    protected $connection = 'mongodb';
    //restricts columns from modifying
    protected $guarded = [];
    // posts has many comments
    // returns all comments on that post
    public function comments()
    {
        return $this->hasMany('App\Comments','on_post');
    }
    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo('App\User','author_id');
    }
}
