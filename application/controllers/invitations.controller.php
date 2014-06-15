<?php
if(!class_exists('Invitations_Controller')) {

    class Invitations_Controller extends Base_Controller {

        public $model;

        public function __construct(Invitations_Model $model) {
            $this->model = $model;
            parent::__construct($model);
        }

        public function removeMembership($owner_name, $list_title) {
            $owner_name = Utils::washInput($owner_name);
            $list_title = Utils::washInput($list_title);
            $owner_id = $this->model->getUserId($owner_name);
            $list_id = $this->model->getListId($list_title, $owner_id);
            $this->model->deleteMembership($list_id, $_SESSION['user_id']);
        }

        public function acceptInvitation($inviter_name, $list_title) {
            $inviter_name = Utils::washInput($inviter_name);
            $list_title = Utils::washInput($list_title);
            $inviter_id = $this->model->getUserId($inviter_name);
            $list_id = $this->model->getListId($list_title, $inviter_id);
            $this->model->insertMembership($inviter_id, $list_id, $_SESSION['user_id']);
            $this->model->deleteInvitation($inviter_id, $list_id, $_SESSION['user_id']);
        }

        public function declineInvitation($inviter_name, $list_title) {
            $inviter_name = Utils::washInput($inviter_name);
            $list_title = Utils::washInput($list_title);
            $inviter_id = $this->model->getUserId($inviter_name);
            $list_id = $this->model->getListId($list_title, $inviter_id);
            $this->model->deleteInvitation($inviter_id, $list_id, $_SESSION['user_id']);
        }

        public function cancelInvitation($invited_name, $list_title) {
            $invited_name = Utils::washInput($invited_name);
            $list_title = Utils::washInput($list_title);
            $invited_id = $this->model->getUserId($invited_name);
            $list_id = $this->model->getListId($list_title);
            $this->model->deleteInvitation($_SESSION['user_id'], $list_id, $invited_id);
        }

        //TODO move to proper file
        public function invitationExists($user_id, $list_id) {
            $inv_id = $this->model->getInvitation($user_id, $list_id);
            if($inv_id == 0) {
                return false;
            } else {
                return true;
            }
        }

        public function inviteUser($username, $list_title) {
            $errors = Array();
            $username = Utils::washInput($username);
            $inviter_id = $_SESSION['user_id'];
            $list_id = $this->model->getListId($list_title);
            $user_id = $this->model->getUserId($username);

            if($username == $_SESSION['username']) {
                $errors[] = 'You cannot invite yourself.';
            }

            if($this->model->membershipExists($user_id, $list_id)) {
                $errors[] = 'User is already subscribing to that list.';
            }

            if($this->invitationExists($user_id, $list_id)) {
                $errors[] = 'User already invited.';
            }

            if($user_id < 1) {
                $errors[] = 'There is no such user.';
            }

            if(count($errors) >= 1) {
                $_SESSION['errors'] = $errors;
            } else {
                $this->model->insertInvite($inviter_id, $user_id, $list_id);
            }
        }

    }

}