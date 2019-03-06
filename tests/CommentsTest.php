<?php
namespace Jobcerto\Comments\Tests;

use Illuminate\Foundation\Auth\User;
use Jobcerto\Comments\Tests\Models\Post;

class CommentsTest extends TestCase
{
    /** @test */
    public function models_can_store_comments()
    {
        $post = Post::create([
            'title' => 'Some post',
        ]);

        $post->comment('this is a comment');
        $post->comment('this is a different comment');

        $this->assertCount(2, $post->comments);

        $this->assertSame('this is a comment', $post->comments[0]->body);
        $this->assertSame('this is a different comment', $post->comments[1]->body);
    }

    /** @test */
    public function comments_without_users_have_no_relation()
    {
        $post = Post::create([
            'title' => 'Some post',
        ]);
        $comment = $post->comment('this is a comment');
        $this->assertNull($comment->owner);
        $this->assertNull($comment->owner_id);
        $this->assertNull($comment->owner_type);
    }

    /** @test */
    public function comments_can_be_posted_as_authenticated_users()
    {
        $user = User::first();

        auth()->login($user);

        $post = Post::create([
            'title' => 'Some post',
        ]);

        $comment = $post->comment('this is a comment');

        $this->assertSame($user->toArray(), $comment->owner->toArray());
    }

    /** @test */
    public function comments_can_be_posted_as_different_users()
    {
        $user = User::first();
        $post = Post::create([
            'title' => 'Some post',
        ]);
        $comment = $post->commentAsUser($user, 'this is a comment');
        $this->assertSame($user->toArray(), $comment->owner->toArray());
    }

    /** @test */
    public function comments_resolve_the_commented_model()
    {
        $user = User::first();
        $post = Post::create([
            'title' => 'Some post',
        ]);
        $comment = $post->comment('this is a comment');
        $this->assertSame($comment->commentable->id, $post->id);
        $this->assertSame($comment->commentable->title, $post->title);
    }

}
