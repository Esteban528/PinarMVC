<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__.'/misc.php';
require __DIR__.'/config/database.php';

use Controller\EmailController;

//Global Functions
$db = connectDB();
// $email = EmailController::configure();

Use Model\Base;
Base::setDB($db);

function showFormat ($value, $bool = false)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';

  if($bool){
    exit;
  }
}

function calcTime($fechaPublicacion) {
  $fechaPublicacion_timestamp = strtotime($fechaPublicacion);
  $ahora = time();
  $diferenciaSegundos = $ahora - $fechaPublicacion_timestamp;
  $diferenciaDias = round($diferenciaSegundos / (60 * 60 * 24));

  if ($diferenciaDias == 0) {
      return "Hoy";
  } elseif ($diferenciaDias == 1) {
      return "Hace 1 día";
  } else {
      return "Hace " . $diferenciaDias . " días";
  }
}

function s($html) : string {
  $s = htmlspecialchars($html);
  return $s;
}