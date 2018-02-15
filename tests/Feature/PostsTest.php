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
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(Posts::class)->create();

    /*More code*/
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    // public function testPostStore()
    // {
    //     $post = new Posts();
    //     $post->title = 'An Awesome Posts';
    //     $post->body = 'Lorem ipsum dolor sit amet';
    //     $post->slug = str_slug($post->title);
    //     $post->author_id = 1;
    //
    //     $this->assertEquals('An Awesome Posts', $post->title);
    //     $this->assertTrue(true);
    //
    //     $post->save();
    //
    //     $newPost = Posts::first();
    //     $this->assertEquals($post->title, $newPost->title);
    // }

    public function test_have_10_posts()
    {
        $this->assertEquals(10, Posts::count());
    }
}
