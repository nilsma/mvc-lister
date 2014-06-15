<?php

if(!class_exists('Register_Controller')) {

    class Register_Controller extends Base_Controller {

        public $model;

        public function __construct(Register_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function validatePassword($password) {
            $validate = false;

            if((strlen($password) >= 6) &&
                (strlen($password) <= 16) &&
                (preg_match("#[a-z]+#", $password))  &&
                (preg_match("#[0-9]+#", $password)) &&
                (preg_match("#[A-Z]+#", $password))) {
                $validate = true;
            }

            return $validate;

        }

        public function getRegistrationErrors($username, $email, $pwd1, $pwd2) {
            $errors = array();

            if(empty($username)) {
                $errors[] = 'You forgot to enter a username';
            }

            if(!strlen($username) >= 6 && !strlen($username) <= 16) {
                $errors[] = 'Your username must be 6-16 characters long';
            }

            if(empty($email)) {
                $errors[] = 'Your forgot to enter an email address';
            }

            if((!filter_var($email, FILTER_VALIDATE_EMAIL)) && (!strlen($email) < 50)) {
                $errors[] = 'The email you entered is not valid';
            }

            if($pwd1 != $pwd2) {
                $errors[] = 'The passwords does not match';
            }

            if(!$this->validatePassword($pwd1)) {
                $errors[] = 'The password must be 6-16 characters, and have upper and lower case, and at least one number';
            }

            if($this->model->usernameExists($username)) {
                $errors[] = 'That username already exists';
            }

            if($this->model->emailExists($email)) {
                $errors[] = 'That email is already in use';
            }

            return $errors;
        }

        public function registerUser($username, $email, $pwd1, $pwd2) {
            $errors = $this->getRegistrationErrors($username, $email, $pwd1,$pwd2);

            if(count($errors) < 1) {
                $this->model->addUserToDatabase($username, $email, $pwd1);
                $_SESSION['auth'] = true;
                $_SESSION['username'] = $username;
                header('Location: member.php');
            } else {
                $_SESSION['errors'] = $errors;
            }
        }

    }

}