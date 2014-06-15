<?php

if(!class_exists('Edit_Member_Controller')) {

    class Edit_Member_Controller extends Base_Controller {

        public $model;

        public function __construct(Edit_Member_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function changePassword($current, $new, $repeat) {
            $errors = array();

            if(!$this->model->validateLogin($_SESSION['username'], $current)) {
                $errors[] = 'You entered the wrong password';
            }

            if(empty($new)) {
                $errors[] = 'You forgot to enter a new password';
            }

            if(empty($repeat)) {
                $errors[] = 'You forgot to repeat the password';
            }

            if($new != $repeat) {
                $errors[] = 'The passwords you entered does not match';
            }

            if(count($errors) >= 1) {
                $_SESSION['errors'] = $errors;
            } else {
                $hashed = $this->model->hashPassword($new);
                $this->model->updatePassword($_SESSION['user_id'], $hashed);
                $success[] = 'The password has been successfully updated';
                $_SESSION['success'] = $success;

            }
        }

        public function validateEmail($new, $repeat) {
            $errors = array();

            if(empty($new)) {
                $errors[] = 'You forgot to fill in both email fields';
            }

            if(empty($repeat)) {
                $errors[] = 'You forgot to fill in both email fields';
            }

            if($new != $repeat) {
                $errors[] = 'The email addresses does not match';
            }

            if(!filter_var($new, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'The email address is not valid';
            }

            if(count($errors) >= 1) {
                $_SESSION['errors'] = $errors;
                return false;
            } else {
                $success[] = 'The email address has been updated';
                $_SESSION['success'] = $success;
                return true;
            }
        }

        public function changeEmail($new, $repeat) {
            $new = Utils::washInput($new);
            $repeat = Utils::washInput($repeat);
            if($this->validateEmail($new, $repeat)) {
                $this->model->updateEmail($_SESSION['user_id'], $new);
                $_SESSION['email'] = $new;
            }
        }

    }

}