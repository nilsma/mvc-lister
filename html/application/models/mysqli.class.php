<?php

require_once 'database.class.php';

if(!class_exists('Mysqli')) {

  class Mysqli extends Database {
    
    public function __construct() { }

  }

}

?>