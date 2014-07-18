<?php
if(!class_exists('Edit_List_Model')) {

    class Edit_List_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function deleteMembership($owner_id, $list_id, $member_id) {
            $db = $this->connect();

            $query = $db->real_escape_string("DELETE FROM members WHERE owner_id=? AND list_id=? AND user_id=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('iii', $owner_id, $list_id, $member_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

        public function getListMembers($list_id) {
            $db = $this->connect();

            $query = $db->real_escape_string("SELECT user_id FROM members WHERE list_id=?");

            $members = array();

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->bind_result($user_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $members[] = $user_id;
                }

                return $members;
            }

            $stmt->close();
            $db->close();
        }

        public function setListTitle($list_id, $new_title) {
            $db = $this->connect();

            $query = $db->real_escape_string("UPDATE lists SET title=? WHERE id=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('si', $new_title, $list_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

    }

}