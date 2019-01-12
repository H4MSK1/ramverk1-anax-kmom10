<?php

namespace H4MSK1\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use H4MSK1\Models\User;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                "password" => [
                    "type" => "password",
                    "validation" => ["not_empty"],
                ],
                "password-verify" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "password"
                    ],
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
        $user = new User();
        $user->username = $this->form->value('username');
        $user->password = $this->form->value('password');
        $user->email = $this->form->value('email');
        $user->gravatar = $this->form->value('email');
        $user->about = "Hey, I'm *Admin* and this is my page.";
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
        $this->di->get("response")->redirect("user/login")->send();
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
