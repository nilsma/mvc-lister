<?php

if(!class_exists('Register_Controller')) {

    class Register_Controller extends Base_Controller {

        public $model;

        public function __construct(Register_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function getRegistrationErrors($username, $email, $pwd1, $pwd2) {
            $errors = array();

            if(empty($username)) {
                $errors[] = 'You forgot to enter a username';
            }

            if(empty($email)) {
                $errors[] = 'Your forgot to enter an email address';
            }

            if($pwd1 != $pwd2) {
                $errors[] = 'The passwords does not match';
            }

            if($this->model->usernameExists($username)) {
                $errors[] = 'That username already exists';
            }

            if($this->model->emailExists($email)) {
                $errors[] = 'That email is already in use';
            }

            return $errors;
        }

        public function registerUser($username, $email, $pwd) {
            $this->model->addUserToDatabase($username, $email, $pwd);
        }

    }

}