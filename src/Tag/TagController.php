<?php

namespace H4MSK1\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use H4MSK1\Tag\HTMLForm\CreateForm;
use H4MSK1\Tag\HTMLForm\UpdateForm;
use H4MSK1\Tag\HTMLForm\LoginForm;
use H4MSK1\Auth\AuthMiddlewareTrait;
use H4MSK1\Models\User;
use H4MSK1\Models\Tag;

class TagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    use AuthMiddlewareTrait;

    public function initialize()
    {
        //$this->onlyAuth($this->di, [
        //    'except' => ['user/login', 'user/register'],
        //]);
    }

    public function allActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("app/tag/all", [
            "tags" => Tag::all(),
        ]);

        return $page->render([
            "title" => "Tags",
        ]);
    }

    public function readActionGet($id) : object
    {
        $page = $this->di->get("page");

        $page->add("app/tag/read", [
            "tag" => Tag::find($id),
        ]);

        return $page->render([
            "title" => "Tag",
        ]);
    }
}
