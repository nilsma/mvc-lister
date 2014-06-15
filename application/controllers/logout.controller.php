<?php

if(!class_exists('Logout_Controller')) {

    class Logout_Controller extends Base_Controller {

        public function __construct(Logout_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function logout() {
            $_SESSION = array();
            unset($_SESSION);
            header('Location: index.php');
        }

    }

}
