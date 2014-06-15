<?php

if(!class_exists('Member_Controller')) {

    class Member_Controller extends Base_Controller {

        public $model;

        public function __construct(Member_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function setCurrentList($list_title, $list_owner) {
            if(is_int($list_title)) {
                $list_title = $this->model->getListTitle($list_title);
            }

            if(is_int($list_owner)) {
                $list_owner = $this->model->getUsername($list_owner);
            }

            $list_title = Utils::washInput($list_title);
            $list_owner = Utils::washInput($list_owner);

            if(!empty($list_title) && !empty($list_owner)) {
                $owner_id = $this->model->getUserId($list_owner);
                $_SESSION['chosen'] = $this->model->getListId($list_title, $owner_id);
            } else {
                $_SESSION['chosen'] = NULL;
            }
        }

        public function getLists($user_id) {
            return $this->model->getOwnLists($user_id);
        }

        public function getCurrentUserId() {
            return $this->model->getUserId($_SESSION['username']);
        }

        public function getAllLists() {
            $lists = $this->model->getMembershipLists($_SESSION['user_id']);
            $ownLists = $this->model->getOwnLists($_SESSION['user_id']);

            foreach($ownLists as $key => $val) {
                $lists[$key] = $val;
            }

            return $lists;
        }

        public function addItem($list_id, $item_name) {
            $item_name = Utils::washInput($item_name);
            if(!empty($item_name) && !empty($list_id)) {
                $this->model->insertItem($list_id, $item_name);
            }
        }

        public function removeItem($list_id, $item_name) {
            $item_name = Utils::washInput($item_name);
            if(!empty($item_name) && !empty($list_id)) {
                $this->model->deleteItem($list_id, $item_name);
            }
        }

        public function toggleItem($list_id, $item_name) {
            $item_name = Utils::washInput($item_name);
            $this->model->tapItem($list_id, $item_name);
        }

        public function getUserEmail() {
            return $this->model->getUserEmail($_SESSION['user_id']);
        }

    }

}