<?php

if(!class_exists('View')) {

  class View {

    private $model;
    private $ctrl;
    private $title;
    private $page_id;
    private $headers;
    
    public function __construct(Model $model, Controller $ctrl, $title, $page_id) {
      $this->model = $model;
      $this->ctrl = $ctrl;
      $this->title = $title;
      $this->page_id = $page_id;
    }

    public function render() {
      $html = '';

      $html = $html . $this->buildHead();
      $html = $html . $this->buildBody();

      echo $html;
    }

    public function buildHead() {
      $headers = $this->headers;

      $html = '';
      $html = $html . '<!DOCTYPE html>' . "\n";
      $html = $html . '<html>' . "\n";
      $html = $html . '  <head>' . "\n";

      if(count($headers) > 0) { 
	foreach($headers as $entry) {
	  $html = $html . '    ' . $entry;
	}
      }

      $html = $html . '    <title>' . $this->title . '</title>' . "\n";
      $html = $html . '  </head>' . "\n";

      return $html;
    }

    public function buildBody() {
      $html = '';

      $html = $html . '  <body id="' . $this->page_id . '">' . "\n";      
      $html = $html . $this->buildFooter();
      $html = $html . '  </body>' . "\n";
      $html = $html . '</html>';

      return $html;
    }

    public function buildFooter() {
      $html = '';

      $html = $html . '    <footer>' . "\n";
      $html = $html . '    </footer>' . "\n";

      return $html;
    }

    public function setHeaders($headers) {
      $this->headers = $headers;
    }

  }

}

?>