<?php

if(!class_exists('Member_Model')) {

    class Member_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getItems($title) {
            $list_id = $this->getListId($title);
            $sql = $this->connect();

            $query = "SELECT id, name, tapped FROM items WHERE list_id=?";
            $query = $sql->real_escape_string($query);

            $items = array();

            $stmt = $sql->stmt_init();
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
            $sql->close();
        }

        public function insertItem($list_title, $item_name) {
            $list_id = $this->getListId($list_title);
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