<?php

if(!class_exists('View')) {

  class View {

    private $model;
    private $ctrl;
    private $title;
    private $page_id;
    private $head_entries;
    
    public function __construct(Model $model, Controller $ctrl, $title, $page_id) {
      $this->model = $model;
      $this->ctrl = $ctrl;
      $this->title = $title;
      $this->page_id = $page_id;
    }

    public function render($head, $body, $footer) {
      $footer = $this->ctrl->buildFooter($footer);
      
      $html = '';
      $html = $html . $this->ctrl->buildHead($head, $this->title);
      $html = $html . $this->ctrl->buildBody($this->page_id, $body, $footer);

      echo $html;
    }

  }

}

?>