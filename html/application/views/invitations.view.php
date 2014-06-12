<?php
if(!class_exists('Invitations_View')) {

    class Invitations_View extends Base_View {

        public $page_id;

        public function __construct(Invitations_Model $model, $ctrl, $title, $page_id) {
            $this->page_id = $page_id;
            $this->model = $model;
            parent::__construct($model, $ctrl, $title, $page_id);
        }

        public function render() {
            include 'application/templates/head.html';

            $html = "\n";
            $html .= $this->buildHeader($this->page_id);
            $html .= $this->buildInviteForm();
            $html .= $this->buildInvitationsOverview();
            $html .= $this->buildOfferedInvitations();
            $html .= $this->buildMemberships();

            echo $html;

            include 'application/templates/footer.html';
        }

        public function buildMemberships() {
            $memberships = $this->model->getMemberships($_SESSION['user_id']);

            $html = '';

            $html .= '<div id="memberships">' . "\n";

            if(count($memberships) >= 1) {
                $html .= '<table>' . "\n";

                foreach($memberships as $list_id) {
                    $html .= '<tr>';
                    $html .= '<td>You currently subscribe to <span class="list_owner">' . $this->model->getListOwnerUsername($list_id) . '</span>\'s ';
                    $html .= 'list <span class="membership_list_title">' . $this->model->getListTitle($list_id) . '</span></td>';
                    $html .= '<td><button class="unsubscribe_list">Unsubscribe</button></td>';
                    $html .= '</tr>' . "\n";
                }

                $html .= '</table>' . "\n";
            } else {
                $html .= '<p>You are not member of any lists yet ...</p>' . "\n";
            }

            $html .= '</div> <!-- end #memberships -->' . "\n";

            return $html;
        }

        public function buildInvitationsOverview() {
            $ownInvitations = $this->model->getOwnInvitations($_SESSION['user_id']);

            $html = '';
            $html .= '<div id="own_invitations">' . "\n";

            if(count($ownInvitations) == 0) {
                $html .= '<p>You have not invited anyone yet ...</p>' . "\n";
            } else {
                $html .= '<table>' . "\n";

                foreach($ownInvitations as $invitation) {
                    $html .= '<tr>' . "\n";
                    $html .= '<td>You have invited <span class="invited">' . $this->model->getUsername($invitation['user_id']) . '</span>';
                    $html .= ' to the list <span class="invited_title">' . $this->model->getListTitle($invitation['list_id']) . '</span></td>';
                    $html .= '<td><button class="cancel_invitation">Cancel</button></td>' . "\n";
                    $html .= '</tr>' . "\n";
                }

                $html .= '</table>' . "\n";
            }

            $html .= '</div> <!-- end #own_invitations -->' . "\n";

            return $html;
        }

        public function buildOfferedInvitations() {
            $offeredInvitations = $this->model->getOfferedInvitations($_SESSION['user_id']);

            $html = '';
            $html .= '<div id="offered_invitations">' . "\n";

            if(count($offeredInvitations) == 0 ) {
                $html .= '<p>There are no invitations for you at the moment ...</p>' . "\n";
            } else {
                $html .= '<table>' . "\n";
                foreach($offeredInvitations as $invitation) {
                    $html .= '<tr>';
                    $html .= '<td><span class="inviter">' . $this->model->getUsername($invitation['inviter_id']) . '</span>';
                    $html .= ' has invited you to the list <span class="inv_title">' . $this->model->getListTitle($invitation['list_id']) . '</span></td>';
                    $html .= '<td><button class="accept_invitation">Accept</button></td>';
                    $html .= '<td><button class="decline_invitation">Decline</button></td>';
                    $html .= '</tr>' . "\n";
                }
                $html .= '</table>' . "\n";
            }
            $html .= '</div> <!-- end #offered_invitations -->' . "\n";

            return $html;
        }

        public function buildInviteForm() {
            $lists = $this->model->getLists($_SESSION['user_id']);

            $html = '';

            $html .= '<div id="invite">' . "\n";

            if((isset($_SESSION['inv_errors'])) && (count($_SESSION['inv_errors']) >= 1)) {
                $inv_errors = $_SESSION['inv_errors'];
                $_SESSION['inv_errors'] = false;
                unset($_SESSION['inv_errors']);

                $html .= '<div id="errors">' . "\n";
                $html .= '<ul>' . "\n";

                foreach($inv_errors as $error) {
                    $html .= '<li>' . $error . '</li>' . "\n";
                }

                $html .= '</ul>' . "\n";
                $html .= '</div> <!-- end #invitation_errors -->' . "\n";
            }

            if(count($lists) >= 1) {
                $html .= '<form name="invite_form" action="" method="POST">' . "\n";
                $html .= '<select name="invite_list_title">' . "\n";

                foreach($lists as $list_id => $title) {
                    $html .= '<option value="' . $title . '">' . $title . '</option>' . "\n";
                }

                $html .= '</select>' . "\n";
                $html .= '<input type="text" name="invite_username" maxlength="30">' . "\n";
                $html .= '<input type="submit" name="submit_invite" value="Invite">' . "\n";
                $html .= '</form>' . "\n";
            } else {
                $html .= '<p>You haven\'t made any lists yet';
            }

            $html .= '</div> <!-- end #invite -->' . "\n";

            return $html;
        }

    }

}