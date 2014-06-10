<?php
if(!class_exists('Invitations_Model')) {

    class Invitations_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
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

        public function insertInvite($user_id, $list_id) {
            $db = $this->connect();

            $query = "INSERT INTO invitations VALUES(null, ?, ?)";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('si', $list_id, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

    }

}