<?php

if(!class_exists('Edit_Member_Controller')) {

    class Edit_Member_Controller extends Base_Controller {

        public $model;

        public function __construct(Edit_Member_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function changePassword($current, $new, $repeat) {
            if($this->model->validateLogin($_SESSION['username'], $current)) {
                if(!empty($new) && !empty($repeat) && ($new == $repeat)) {
                    $hashed = $this->model->hashPassword($new);
                    $this->model->updatePassword($_SESSION['user_id'], $hashed);
                }
            }
        }

        public function changeEmail($new, $repeat) {
            if(!empty($new) && !empty($repeat) && ($new == $repeat)) {
                $this->model->updateEmail($_SESSION['user_id'], $new);
                $_SESSION['email'] = $new;
            }
        }

    }

}