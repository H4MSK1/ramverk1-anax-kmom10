<?php

namespace H4MSK1\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use H4MSK1\Models\User;

/**
 * Form to update an item.
 */
class LoginForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
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
                    "placeholder" => "admin",
                ],
                "password" => [
                    "type" => "password",
                    "validation" => ["not_empty"],
                    "placeholder" => "admin",
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $username = $this->form->value('username');
        $password = $this->form->value('password');

        $user = User::where('username', $username)->first();

        if (! $user || ! $user->verifyPassword($password)) {
            $this->form->rememberValues();
            $this->form->addOutput("Wrong details.");
            return false;
        }

        $this->di->get('session')->set('user', $user->id);
        return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("index")->send();
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
