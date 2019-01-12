<?php

namespace H4MSK1\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use H4MSK1\Models\User;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $user = User::find($di->get('session')->get('user'));
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->username,
                ],
                "email" => [
                    "type" => "email",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],
                "password" => [
                    "type" => "password",
                ],
                "about" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "value" => $user->about
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
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
        $user->username = $this->form->value('username');

        if (! empty($this->form->value('password'))) {
            $user->password = $this->form->value('password');
        }

        $user->email = $this->form->value('email');
        $user->gravatar = $this->form->value('email');
        $user->about = $this->form->value('about');
        $user->save();

        $this->form->addOutput("Your account has now been updated.");

        return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("book")->send();
    //     //$this->di->get("response")->redirect("book/update/{$book->id}");
    // }



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
