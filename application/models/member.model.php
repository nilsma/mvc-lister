<?php

if(!class_exists('Member_Model')) {

    class Member_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getListTitle($list_id) {
            $db = $this->connect();

            $query = $db->real_escape_string("SELECT title FROM lists WHERE id=?");

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->bind_result($title);
                $stmt->fetch();

                return $title;
            }

            $stmt->close();
            $db->close();
        }

        public function getItems($list_id) {
            $db = $this->connect();

            $query = $db->real_escape_string("SELECT id, name, tapped FROM items WHERE list_id=?");

            $items = array();

            $stmt = $db->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->bind_result($id, $name, $tapped);
                $stmt->store_result();
                while($stmt->fetch()) {
                    $item = Array(
                        'id' => $id,
                        'name' => $name,
                        'tapped' => $tapped
                    );
                    $items[] = $item;
                }

                return $items;
            }

            $stmt->close();
            $db->close();
        }

        public function insertItem($list_id, $item_name) {
            $sql = $this->connect();

            $query = "INSERT INTO items VALUES(NULL, ?, ?, 0)";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $list_id, $item_name);
                $stmt->execute();
            }

            $stmt->close();
            $sql->close();
        }

        public function deleteItem($list_id, $item_name) {
            $sql = $this->connect();

            $query = "DELETE FROM items WHERE list_id=? AND name=?";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $list_id, $item_name);
                $stmt->execute();
            }

            $stmt->close();
            $sql->close();
        }

        public function tapItem($list_id, $item_name) {
            $sql = $this->connect();

            $query = "UPDATE items SET tapped = NOT tapped WHERE list_id=? AND name=?";
            $query = $sql->real_escape_string($query);

            $stmt = $sql->stmt_init();
            if(!$stmt->prepare($query)) {
                print("Failed to prepare query: " . $query . "\n");
            } else {
                $stmt->bind_param('is', $list_id, $item_name);
                $stmt->execute();
            }

            $stmt->close();
            $sql->close();
        }

    }

}