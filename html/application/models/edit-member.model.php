<?php

if(!class_exists('Edit_Member_Model')) {

    class Edit_Member_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function updatePassword($user_id, $hashed) {
            $sql = $this->connect();

            $query = "UPDATE users SET password=? WHERE id=?";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('si', $hashed, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $sql->close();
        }

        public function updateEmail($user_id, $new_email) {
            $db = $this->connect();

            $query = "UPDATE users SET email=? WHERE id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('si', $new_email, $user_id);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

    }

}