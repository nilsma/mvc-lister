<?php
if(!class_exists('Controller')) {

  class Controller {    
    
    public function __construct(Model $model) {
      $this->model = $model;
    }

  }

}
?>