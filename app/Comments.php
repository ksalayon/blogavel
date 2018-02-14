<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

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
}
