<?php

namespace H4MSK1\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;
use H4MSK1\Models\Comment;

/**
 * Form to create an item.
 */
class CommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $postId)
    {
        parent::__construct($di);
        $this->postId = $postId;
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "comment" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Submit",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $user = User::find($this->di->get('session')->get('user'));

        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $this->postId;
        $comment->body = $this->form->value('comment');
        $comment->save();

        $user->points = $user->points + 1;
        $user->save();

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $id = $this->postId;
        $post = Post::find($id);

        if ($post->isPostAnswer()) {
            $id = $post->answer_for_post;
        }

        $this->di->get("response")->redirect("question/read/{$id}")->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
