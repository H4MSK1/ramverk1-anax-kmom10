<?php

namespace H4MSK1\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use H4MSK1\User\HTMLForm\CreateForm;
use H4MSK1\User\HTMLForm\UpdateForm;
use H4MSK1\User\HTMLForm\LoginForm;
use H4MSK1\Auth\AuthMiddlewareTrait;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;

class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use AuthMiddlewareTrait;

    public function initialize()
    {
        $this->onlyAuth($this->di, [
            'only' => ['user', 'user/index', 'user/update', 'user/logout'],
        ]);
    }

    public function indexActionGet($id = null) : object
    {
        return $this->profileActionGet($this->di->get('session')->get('user'));
    }

    public function profileActionGet($id)
    {
        $page = $this->di->get("page");

        $page->add("app/user/profile", [
            "user" => User::find($id),
        ]);

        return $page->render([
            "title" => "Profile",
        ]);
    }

    public function allActionGet()
    {
        $page = $this->di->get("page");

        $page->add("app/user/all", [
            "users" => User::latest()->get(),
        ]);

        return $page->render([
            "title" => "Users",
        ]);
    }

    public function logoutActionGet()
    {
        $this->di->get('session')->delete('user');
        return $this->di->get('response')->redirect('user/login')->send();
    }

    public function loginAction()
    {
        $page = $this->di->get("page");
        $form = new LoginForm($this->di);
        $form->check();

        $page->add("app/user/login", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Login",
        ]);
    }

    public function registerAction()
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("app/user/register", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Register",
        ]);
    }

    public function updateAction() : object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $this->di->get('session')->get('user'));
        $form->check();

        $page->add("app/user/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Settings",
        ]);
    }
}
