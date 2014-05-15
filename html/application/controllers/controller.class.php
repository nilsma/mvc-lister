<?php
if(!class_exists('Controller')) {

  class Controller {    
    
    public function __construct(Model $model) {
      $this->model = $model;
    }

    public function sortUsers($users, $column, $axis) {
      foreach($users as $key => $row) {
	$id[$key] = $row['id'];
	$name[$key] = $row['name'];
      }

      if($column == 'id') {
	if($axis == 'ascending') {
	  array_multisort($id, SORT_ASC, $name, SORT_ASC, $users);
	} else {
	  array_multisort($id, SORT_DESC, $name, SORT_ASC, $users);
	}
      } else {
	if($axis == 'ascending') {
	  array_multisort($name, SORT_ASC, $id, SORT_ASC, $users);
	} else {
	  array_multisort($name, SORT_DESC, $id, SORT_ASC, $users);
	}
      }
      
      return $users;
    }

    public function buildUsersTable() {
      $users = $this->sortUsers($this->model->getItems(), 'name', 'ascending');

      $table = '';
      $table = $table . '<table>' . "\n";
      if(count($users)) {
	foreach($users as $user) {
	  $table = $table . '<tr><td>' . $user['id'] . '</td><td>' . $user['name'] . '</td></tr>' . "\n";
	}
      } else {
	$table = $table . '<tr><td>There are no members</td></tr>' . "\n";
      }
      $table = $table . '</table>' . "\n";

      return $table;
    }

    public function buildHead($headers, $title) {
      $html = '';

      $html = $html . '<!DOCTYPE html>' . "\n";
      $html = $html . '<html>' . "\n";
      $html = $html . '<head>' . "\n";

      if(count($headers) > 0) {
        foreach($headers as $entry) {
          $html = $html . $entry;
        }
      }

      $html = $html . '<title>' . $title . '</title>' . "\n";
      $html = $html . '</head>' . "\n";

      return $html;
    }

    public function buildBody($page_id, $body, $footer) {
      $html = '';

      $html = $html . '<body id="' . $page_id . '">' . "\n";
      $html = $html . $body;
      $html = $html . $footer;
      $html = $html . '</body>' . "\n";
      $html = $html . '</html>';

      return $html;
    }

    public function buildFooter($footer) {
      $html = '';

      $html = $html . '<footer>' . "\n";
      $html = $html . $footer;
      $html = $html . '</footer>' . "\n";

      return $html;
    }


  }

}
?>