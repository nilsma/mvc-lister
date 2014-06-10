<?php
if(!class_exists('Base_Controller')) {

    class Base_Controller {

        public $model;

        public function __construct(Base_Model $model) {
            $this->model = $model;
        }

        public function addList($list_title) {
            if(!empty($list_title)) {
                $this->model->insertList($list_title);
            }
        }

        /*
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
        */

        /*
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
        */

    }

}
?>