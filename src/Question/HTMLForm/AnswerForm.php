<?php

namespace H4MSK1\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;

/**
 * Form to create an item.
 */
class AnswerForm extends FormModel
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
                "answer_for_post" => [
                    "type" => "hidden",
                    "value" => $postId,
                ],
                "answer" => [
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
        if (empty($this->form->value('answer_for_post'))) {
            return false;
        }

        $post = new Post();
        $post->store($this->form, $this->di->get('session')->get('user'), false);

        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question/read/{$this->postId}")->send();
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
