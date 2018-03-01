<?php namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Posts;
use App\Comments;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword, HybridRelations;

    protected $connection = 'mysql';

    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'users';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'email', 'password'];
    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = ['password', 'remember_token'];

    // user has many posts
    public function posts()
    {
        return $this->hasMany('App\Posts','author_id');
        //return $this->embedsMany('App\Posts');
    }

    // user has many comments
    public function comments()
    {
        return $this->hasMany('App\Comments','from_user');
    }

    public function can_post()
	{
		$role = $this->role;
		if($role == 'author' || $role == 'admin')
		{
			return true;
		}
		return false;
	}

	public function is_admin()
	{
		$role = $this->role;
		if($role == 'admin')
		{
			return true;
		}
		return false;
	}

    public function getProfile()
    {
        try {
            $data['comments_count'] = $this->comments()->count();
            $data['posts_count'] = Posts::getAllByUser($this->id)->count();
            $data['posts_active_count'] = Posts::getAllByUser($this->id, Posts::PUBLISHED)->count();
            $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
            $data['latest_posts'] = Posts::getAllByUser($this->id);
            $data['latest_comments'] = Comments::getAllByUser($this->id, 1);
        } catch(Exception $e) {
            throw new Exception('Something went wrong with the request. Please try again later.');
        }


        return $data;
    }
}
