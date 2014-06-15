<?php
if(!class_exists('Base_Controller')) {

    class Base_Controller {

        public $model;

        public function __construct(Base_Model $model) {
            $this->model = $model;
        }

        public function addList($list_title) {
            $errors = array();
            $list_title = Utils::washInput(strtolower($list_title));
            $list_title = htmlspecialchars($list_title);

            if(empty($list_title)) {
                $errors[] = 'You forgot to enter a list name';
            }

            if($this->model->listExists($list_title)) {
                $errors[] = 'You already have a list with that name';
            }

            if(count($errors) >= 1) {
                $_SESSION['errors'] = $errors;
            } else {
                $this->model->insertList($list_title);
            }

        }

    }

}
?>