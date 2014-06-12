<?php

if(!class_exists('Member_Controller')) {

    class Member_Controller extends Base_Controller {

        public function __construct(Member_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function setCurrentList($list_title) {
            $list_title = Utils::washInput($list_title);
            if(!empty($list_title) && $this->model->listExists($list_title)) {
                return $list_title;
            } else {
                return NULL;
            }
        }

        public function getLists($user_id) {
            return $this->model->getLists($user_id);
        }

        public function getCurrentUserId() {
            return $this->model->getUserId($_SESSION['username']);
        }

        public function addItem($list_title, $item_name) {
            $list_title = Utils::washInput($list_title);
            $item_name = Utils::washInput($item_name);
            $list_id = $this->model->getListId($list_title);
            if(!empty($item_name) && !empty($list_id)) {
                $this->model->insertItem($list_id, $item_name);
            }
        }

        public function removeItem($list_title, $item_name) {
            $list_title = Utils::washInput($list_title);
            $item_name = Utils::washInput($item_name);
            $list_id = $this->model->getListId($list_title);
            if(!empty($item_name) && !empty($list_id)) {
                $this->model->deleteItem($list_id, $item_name);
            }
        }

        public function toggleItem($list_title, $item_name) {
            $list_title = Utils::washInput($list_title);
            $item_name = Utils::washInput($item_name);
            $list_id = $this->model->getListId($list_title);
            $this->model->tapItem($list_id, $item_name);
        }

        public function getUserEmail() {
            return $this->model->getUserEmail($_SESSION['user_id']);
        }

    }

}