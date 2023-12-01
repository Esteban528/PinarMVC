<?php
namespace Controller;

use MVC\Router;

class PageController {
    public static function index(Router $router) : void {
        
        $router->render('pages/index', [
            'title' => "PinarMVC",
            
            'actual' => "home",
        ]);
    }

    public static function files(Router $router) {

        $headers=[
            'js' => 'javascript'
        ];
        
        $type = $_GET['type'] ?? '';
        $file = $_GET['file'] ?? '';
        $route = __DIR__.'/../public/build/'.$type.'/'.$file;

        if (file_exists($route)) {
            $header = $headers[$type] ?? null;
            $header = is_null($header) ? $type : $header;
            
            header('Content-Type: text/'.$type);
            $contenido = file_get_contents($route);
            echo $contenido;
        }
    }

    

    public static function error(Router $router) {
        $router->render('pages/error', [
            'error' => "404",
            'info' => "Página no encontrada"
        ]);
    }

    public static function image(Router $router) {
        ob_clean();

        $image = $_GET['image'] ?? null;
        $type = $_GET['public'] ?? null;

        if (!is_null($image)) {

            $route = __DIR__.'/../public/images/';
            $route .= $type == "true" ? 'img/'.$image : $image;
    
            if (file_exists($route)) {
                $fileExtension = pathinfo($route, PATHINFO_EXTENSION);
                
                if ($fileExtension === 'jpg' || $fileExtension === 'jpeg') {
                    header('Content-Type: image/jpeg');
                } elseif ($fileExtension === 'png') {
                    header('Content-Type: image/png');
                } elseif ($fileExtension === 'gif') {
                    header('Content-Type: image/gif');
                } else {
                    header('Content-Type: application/octet-stream');
                }
    
                readfile($route);
            } else {
                echo 'Imagen no encontrada';
            }
        } else {
            echo 'Nombre de imagen no proporcionado';
        }
    }

}
