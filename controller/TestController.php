<?php
namespace Controller;

use Model\PostMetadata;
use MVC\Router;
use Model\User;

class TestController {
    public static function list (Router $router) {
        $contentTest = "Hello, this is a test";

        $router->render('test/index', [
            'content' => $contentTest ?? null,
        ]);
    }
}
