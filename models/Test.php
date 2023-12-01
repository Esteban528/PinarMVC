<?php

namespace Model;

class Test extends Base
{
  protected static $dbTable = 'Test';

  protected static $dbCol = [
    "id", "titulo",
  ];

  public $id;
  public $titulo;

  public function __construct($args = []){
    $this->id = $args['id'] ?? 0;
    $this->titulo = $args['titulo'] ?? '';
    
    $this->validate();
  }
}
