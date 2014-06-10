<?php

if(!class_exists('Member_Controller')) {

    class Member_Controller extends Base_Controller {

        public function __construct(Member_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function getUserId() {
            return $this->model->getUserId($_SESSION['username']);
        }

        public function getLists($user_id) {
            return $this->model->getLists($user_id);
        }

        public function addItem($list_title, $item_name) {
            if(!empty($item_name)) {
                $this->model->insertItem($list_title, $item_name);
            }
        }

        public function removeItem($list_title, $item_name) {
            $list_id = $this->model->getListId($list_title);
            if(!empty($item_name)) {
                $this->model->deleteItem($list_id, $item_name);
            }
        }

        public function toggleItem($list_title, $item_name) {
            $list_id = $this->model->getListId($list_title);
            $this->model->tapItem($list_id, $item_name);
        }

        public function getUserEmail() {
            return $this->model->getUserEmail($_SESSION['user_id']);
        }

    }

}