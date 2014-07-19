<?php

require_once '../application/libs/database.class.php';

if(!class_exists('Base_Model')) {

    class Base_Model extends Database {

        public function __construct() { }

        public function insertList($title) {
            $user_id = $_SESSION['user_id'];
            $db = $this->connect();

            $query = "INSERT INTO lists VALUES(NULL, ?, ?)";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $user_id, $title);
                $stmt->execute();
            }

            $stmt->close();
            $db->close();
        }

        public function validateLogin($username, $password) {
            $db = $this->connect();

            $query = "SELECT password FROM users WHERE username=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();

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

            $stmt->close();
            $db->close();
        }

        public function listExists($list_title) {
            $user_id = $_SESSION['user_id'];
            $db = $this->connect();

            $query = $db->real_escape_string("SELECT title FROM lists WHERE owner=? AND title=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $user_id, $list_title);
                $stmt->execute();
                $stmt->store_result();
                $stmt->fetch();
                $num_rows = $stmt->num_rows;
                if($num_rows >= 1) {
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

        public function getNumInvitations($user_id) {
            $db = $this->connect();

            $query = $db->real_escape_string("SELECT * FROM invitations WHERE user_id=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->fetch();
                $num_rows = $stmt->num_rows;

                return $num_rows;
            }

            $stmt->close();
            $db->close();
        }

        public function getListId($title, $user_id = false) {
            if(!$user_id) {
                $user_id = $_SESSION['user_id'];
            }

            $db = $this->connect();

            $query = $db->real_escape_string("SELECT id FROM lists WHERE owner=? AND title=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $user_id, $title);
                $stmt->execute();
                $stmt->bind_result($list_id);
                $stmt->fetch();

                return $list_id;
            }

            $stmt->close();
            $db->close();
        }

        public function getListOwnerUsername($list_id) {
            $db = $this->connect();

            $query = "SELECT username FROM users as u, lists as l WHERE l.id=? AND l.owner=u.id";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->bind_result($username);
                $stmt->fetch();

                return $username;
            }

            $stmt->close();
            $db->close();
        }

        public function getMembershipLists($user_id) {
            $db = $this->connect();

            $query = "SELECT owner_id, list_id FROM members WHERE user_id=?";
            $query = $db->real_escape_string($query);

            $lists = array();

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($owner_id, $list_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $lists[$list_id] = $owner_id;
                }

                return $lists;
            }

            $stmt->close();
            $db->close();
        }

        public function getListTitle($list_id) {
            $db = $this->connect();

            $query = "SELECT title FROM lists WHERE id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->bind_result($list_title);
                $stmt->fetch();

                return $list_title;
            }

            $stmt->close();
            $db->close();
        }

        public function getOwnLists($user_id) {
            $db = $this->connect();

            $query = "SELECT id FROM lists WHERE owner=?";
            $query = $db->real_escape_string($query);

            $lists = array();

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($list_id);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $lists[$list_id] = $_SESSION['user_id'];
                }

                return $lists;
            }

            $stmt->close();
            $db->close();
        }

        public function getNavigation() {
            $nav = array(
                'my lists' => 'member.php',
                'my profile' => 'edit-member.php',
                'edit lists' => 'edit-lists.php',
                'invitations' => 'invitations.php',
                'logout' => 'logout.php'
            );

            return $nav;
        }

        public function getUsername($user_id) {
            $db = $this->connect();

            $query = "SELECT username FROM users WHERE id=?";
            $query = $db->real_escape_string($query);

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $user_id);
                $stmt->execute();
                $stmt->bind_result($username);
                $stmt->fetch();

                return $username;
            }

            $stmt->close();
            $db->close();
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