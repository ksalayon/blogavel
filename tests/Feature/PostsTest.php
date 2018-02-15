<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Posts;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Posts::truncate();
        factory(Posts::class)->create();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostStore()
    {
        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 1;

        $this->assertEquals('An Awesome Posts', $post->title);
        $this->assertTrue(true);

        $post->save();

        $newPost = Posts::find($post->id);
        $this->assertEquals($post->title, $newPost->title);
    }

    public function testGetAllByUser()
    {
        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 1;
        $post->save();

        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 1;
        $post->save();

        $userPosts = Posts::getAllByUser(5);
        $this->assertEquals(count($userPosts), 2);
    }

    public function testGetAllDraftByUser()
    {
        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 0;
        $post->save();

        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 0;
        $post->save();

        $post = new Posts();
        $post->title = 'An Awesome Posts II';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 1;
        $post->save();

        $userPosts = Posts::getAllByUser(5, Posts::DRAFT);
        $this->assertEquals(count($userPosts), 2);
    }

    public function testGetAllPublishedByUser()
    {
        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 0;
        $post->save();

        $post = new Posts();
        $post->title = 'An Awesome Posts';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 0;
        $post->save();

        $post = new Posts();
        $post->title = 'An Awesome Posts II';
        $post->body = 'Lorem ipsum dolor sit amet';
        $post->slug = str_slug($post->title);
        $post->author_id = 5;
        $post->active = 1;
        $post->save();

        $userPosts = Posts::getAllByUser(5, Posts::PUBLISHED);
        $this->assertEquals(count($userPosts), 1);
    }

}
