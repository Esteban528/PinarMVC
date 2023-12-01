<?php

namespace MVC;

class Router {
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function __construct()
    {
        
    }

    public function addGet($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

    public function addPost($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    public function checkRoutes() {
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $urlExplode = explode("?", $currentUrl)[0] ?? null;

        if (!is_null($urlExplode)) {
            $currentUrl = $urlExplode;
        }
        
        if($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        }else{ 
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        }
        else {
            header('Location: /error');
        }
    }
    
    public function render($view, $datos = []) {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        
        $msg = isset($msg) ? $msg : null;
        $messages = isset($messages) ? $messages : [];

        
        if(is_null($msg)) {
            $msg = [];
            $msg_id = $_GET['msg'] ?? null;
            
            if (!is_null($msg_id)) {
                $msg = Misc::$msg[intval($msg_id)];
            }
        }       

        ob_start(); 
        include_once __DIR__ . "/views/$view.php";
        $content = ob_get_clean(); // Contenido cargado
        include_once __DIR__ . '/views/layout.php';
    }
}
