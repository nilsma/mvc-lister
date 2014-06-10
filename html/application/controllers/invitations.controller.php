<?php
if(!class_exists('Invitations_Controller')) {

    class Invitations_Controller extends Base_Controller {

        public $model;

        public function __construct(Invitations_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function invitationExists($user_id, $list_id) {
            $inv_id = $this->model->getInvitation($user_id, $list_id);
            if($inv_id == 0) {
                return false;
            } else {
                return true;
            }
        }

        public function inviteUser($inv_username, $inv_list) {
            $errors = Array();
            $list_id = $this->model->getListId($inv_list);
            $inv_user_id = $this->model->getUserId($inv_username);

            if($this->invitationExists($inv_user_id, $list_id)) {
                $errors[] = 'User already invited.';
            }

            if($inv_user_id < 1) {
                $errors[] = 'There is no such user.';
            }

            if(!count($errors) >= 1) {
                $this->model->insertInvite($inv_user_id, $list_id);
            } else {
                $_SESSION['inv_errors'] = $errors;
            }
        }

    }

}