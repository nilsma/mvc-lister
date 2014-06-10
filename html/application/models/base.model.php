<?php

require_once 'application/libs/database.class.php';

if(!class_exists('Base_Model')) {

    class Base_Model extends Database {

        public function __construct() { }

        public function insertList($title) {
            $user_id = $_SESSION['user_id'];
            $sql = $this->connect();

            $query = "INSERT INTO lists VALUES(NULL, ?, ?)";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $user_id, $title);
                $stmt->execute();
            }

            $stmt->close();
            $sql->close();
        }

        public function validateLogin($username, $password) {
            $db = new Database();
            $sql = $db->connect();

            $query = "SELECT password FROM users WHERE username=?";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();

            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result($fetched);
                $stmt->fetch();
                if(crypt($password, $fetched) == $fetched) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function usernameExists($username) {
            $id = $this->getUserId($username);

            if($id > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function getListId($title) {
            $user_id = $_SESSION['user_id'];
            $lists = $this->getLists($user_id);
            $list_id = 0;

            foreach($lists as $key => $val) {
                if($val == $title) {
                    $list_id = $key;
                }
            }

            return $list_id;
        }

        public function getLists($user_id) {
            $sql = $this->connect();

            $query = "SELECT id, title FROM lists WHERE owner=?";
            $query = $sql->real_escape_string($query);

            $lists = array();

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($id, $title);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $lists[$id] = $title;
                }

                return $lists;
            }

            $stmt->close();
            $sql->close();
        }

        public function getNavigation() {
            $nav = array(
                'My Lists' => 'member.php',
                'My Profile' => 'edit-member.php',
                'Edit Lists' => 'edit-lists.php',
                'Invitations' => 'invitations.php',
                'Logout' => 'logout.php'
            );

            return $nav;
        }

        public function getUserId($username) {
            $sql = $this->connect();

            $query = "SELECT id FROM users WHERE username=? LIMIT 1";
            $query = mysqli_real_escape_string($sql, $query);

            $stmt = $sql->stmt_init();

            if(!$stmt->prepare($query)) {
                print("Failed while preparing query");
            } else {
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result($id);
                $stmt->fetch();

                return $id;
            }
        }

        public function getUserEmail($user_id) {
            $db = $this->connect();

            $query = "SELECT email FROM users WHERE id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print('Failed to prepare query: ' . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->fetch();

                return $email;
            }
        }

        public function hashPassword($password) {
            //TODO relocate
            $cost = 10;
            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
            $salt = sprintf("$2a$%02d$", $cost) . $salt;
            $hashed = crypt($password, $salt);

            return $hashed;
        }

    }
}

?>