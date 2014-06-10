<?php

if(!class_exists('Login_Controller')) {

    class Login_Controller extends Base_Controller {

        public function __construct(Login_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function getLoginErrors($username, $password) {
            $errors = array();

            if(!isset($username) || empty($username)) {
                $errors[] = 'You must enter your username';
            }

            if(!isset($password) || empty($password)) {
                $errors[] = 'You must enter your username';
            }

            if(!$this->model->validateLogin($username, $password)) {
                $errors[] = 'Wrong username or password';
            }

            return $errors;
        }

    }

}