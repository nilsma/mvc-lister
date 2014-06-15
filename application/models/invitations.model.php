<?php
if(!class_exists('Invitations_Model')) {

    class Invitations_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function insertMembership($inviter_id, $list_id, $user_id) {
            $db = $this->connect();

            $query = "INSERT INTO members VALUES(NULL, ?, ?, ?)";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('iii', $inviter_id, $list_id, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

        public function membershipExists($user_id, $list_id) {
            $exists = false;
            $memberships = $this->getMemberships($user_id);

            foreach($memberships as $membership) {
                if($membership == $list_id) {
                    $exists = true;
                    break;
                }
            }

            return $exists;
        }

        public function getMemberships($user_id) {
            $memberships = array();
            $db = $this->connect();

            $query = "SELECT list_id FROM members WHERE user_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($list_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $memberships[] = $list_id;
                }

                return $memberships;
            }

            $stmt->close();
            $db->close();
        }

        public function deleteMembership($list_id, $user_id) {
            $db = $this->connect();

            $query = "DELETE FROM members WHERE list_id=? AND user_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('ii', $list_id, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

        public function deleteInvitation($inviter_id, $list_id, $user_id) {
            $db = $this->connect();

            $query = "DELETE FROM invitations WHERE inviter_id=? AND list_id=? AND user_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('iii', $inviter_id, $list_id, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

        public function getOwnInvitations($user_id) {
            $invitations = Array();
            $db = $this->connect();

            $query = "SELECT list_id, user_id FROM invitations WHERE inviter_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($list_id, $user_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $invitation = array(
                        'list_id' => $list_id,
                        'user_id' => $user_id
                    );
                    $invitations[] = $invitation;
                }

                return $invitations;
            }

            $stmt->close();
            $db->close();
        }

        public function getOfferedInvitations($user_id) {
            $invitations = Array();
            $db = $this->connect();

            $query = "SELECT inviter_id, list_id FROM invitations WHERE user_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($inviter_id, $list_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $invitation = array(
                        'inviter_id' => $inviter_id,
                        'list_id' => $list_id
                    );
                    $invitations[] = $invitation;
                }

                return $invitations;
            }

            $stmt->close();
            $db->close();
        }

        public function getInvitation($user_id, $list_id) {
            $db = $this->connect();

            $query = "SELECT id FROM invitations WHERE user_id=? AND list_id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('ii', $user_id, $list_id);
                $stmt->execute();
                $stmt->bind_result($id);
                $stmt->fetch();

                return $id;
            }

            $stmt->close();
            $db->close();

        }

        public function insertInvite($inviter_id, $user_id, $list_id) {
            $db = $this->connect();

            $query = "INSERT INTO invitations VALUES(null, ?, ?, ?)";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('iii', $inviter_id, $list_id, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

    }

}