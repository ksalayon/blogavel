<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Exception;

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

    public static function store($data)
    {
        $post = new self($data);

        try {
            $post->save();
            return true;
        } catch(Exception $e) {
            throw new Exception('Something went wrong when saving. Please try again.');
        }

    }

    public function upd($data)
    {
        $title = $data['title'];
        $slug = str_slug($title);
        $duplicate = Posts::where('slug',$slug)->first();
        if($duplicate)
        {
            if($duplicate->id != $this->id)
            {
                throw new Exception('Title already exists.');
            }
            else
            {
                $post->slug = $slug;
            }
        }

        $this->title = $title;
        $this->body = $data['body'];
        $this->active = $data['active'];

        try{
            $this->save();
            return true;
        } catch(Exception $e) {
            throw new Exception('Something went wrong with the update. Please try again.');
        }


    }


}
