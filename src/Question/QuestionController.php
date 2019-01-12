<?php

namespace H4MSK1\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use H4MSK1\Question\HTMLForm\CreateForm;
use H4MSK1\Question\HTMLForm\CommentForm;
use H4MSK1\Question\HTMLForm\AnswerForm;
use H4MSK1\Auth\AuthMiddlewareTrait;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;

class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use AuthMiddlewareTrait;

    public function initialize()
    {
        $this->onlyAuth($this->di, [
            'only' => ['question/comment/{param}', 'question/answer/{param}', 'question/create'],
        ]);
    }

    public function indexActionGet()
    {
        return $this->allActionGet();
    }

    public function allActionGet()
    {
        $page = $this->di->get("page");

        $page->add("app/question/all", [
            "questions" => Post::isQuestionOnly()->latest()->get(),
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }

    public function readActionGet($id)
    {
        $page = $this->di->get("page");

        $page->add("app/question/read", [
            "question" => Post::isQuestionOnly()->where('id', $id)->first(),
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }

    public function createAction()
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("app/question/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create question",
        ]);
    }

    public function commentAction($id)
    {
        $page = $this->di->get("page");
        $form = new CommentForm($this->di, $id);
        $form->check();

        $page->add("app/question/comment", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Comment post",
        ]);
    }

    public function answerAction($id)
    {
        $page = $this->di->get("page");
        $form = new AnswerForm($this->di, $id);
        $form->check();

        $page->add("app/question/answer", [
            "form" => $form->getHTML(),
            "question" => Post::isQuestionOnly()->where('id', $id)->first(),
        ]);

        return $page->render([
            "title" => "Answer question",
        ]);
    }

    public function acceptActionGet($postId, $answerId)
    {
        $post = Post::find($postId);
        $post->accepted_answer = $answerId;
        $post->save();

        $acceptor = User::find($post->user_id);
        $acceptor->increment('points', 5);
        $acceptor->save();

        $user = User::find(Post::find($answerId)->user_id);
        $user->increment('points', 15);

        return $this->di->get("response")->redirect("question/read/{$postId}")->send();
    }

    public function deleteActionGet($id)
    {
        $post = Post::isQuestionOnly()->where('id', $id)->first();
        $post->tag()->delete();
        $post->comment()->delete();
        $post->user()->delete();
        $post->delete();

        return $this->di->get("response")->redirect("question/all")->send();
    }
}
