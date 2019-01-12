<?php

namespace H4MSK1\Vote;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use H4MSK1\Auth\AuthMiddlewareTrait;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;
use H4MSK1\Models\Comment;

class VoteController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use AuthMiddlewareTrait;

    public function initialize()
    {
        $this->onlyAuth($this->di);
    }

    public function postActionGet($id, $points)
    {
        $post = Post::find($id);

        if ($points == 1) {
            $post->points = $post->points + 1;
        } else if ($points == 0) {
            $post->points = $post->points - 1;
        }

        $post->save();

        $user = User::findOrFail($this->di->get('session')->get('user'));
        $user->increment('votes');
        $user->increment('points', 10);

        return $this->di->get("response")->redirect("question/read/{$post->getQuestionId()}")->send();
    }

    public function commentActionGet($id, $points)
    {
        $comment = Comment::find($id);

        if ($points == 1) {
            $comment->points = $comment->points + 1;
        } else if ($points == 0) {
            $comment->points = $comment->points - 1;
        }

        $comment->save();

        $user = User::findOrFail($this->di->get('session')->get('user'));
        $user->increment('votes');
        $user->increment('points', 5);

        return $this->di->get("response")->redirect("question/read/{$comment->post->getQuestionId()}")->send();
    }
}
