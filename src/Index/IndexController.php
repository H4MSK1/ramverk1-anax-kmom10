<?php

namespace H4MSK1\Index;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use VendorName\User\HTMLForm\UserLoginForm;
use VendorName\User\HTMLForm\CreateUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

// use Illuminate\Database\Capsule\Manager as Capsule;
use H4MSK1\Auth\AuthMiddlewareTrait;
use H4MSK1\Models\User;
use H4MSK1\Models\Post;
use H4MSK1\Models\Tag;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class IndexController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use AuthMiddlewareTrait;

    public function initialize()
    {
        //$this->onlyAuth($this->di);
    }

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("app/index", [
            "users" => User::orderBy('points', 'desc')->take(6)->get(),
            "tags" => Tag::withCount('posttag')->orderBy('posttag_count', 'desc')->take(10)->get(),
            "questions" => Post::isQuestionOnly()->latest()->take(6)->get(),
        ]);

        return $page->render([
            "title" => "Index",
        ]);
    }

    public function aboutActionGet()
    {
        $page = $this->di->get("page");

        $page->add("app/about");

        return $page->render([
            "title" => "About",
        ]);
    }
}
