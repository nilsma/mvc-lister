<?php
if(!class_exists('Edit_Lists_Model')) {

    class Edit_Lists_Model extends Base_Model {

        public function __construct() {
            parent::__construct();
        }

        public function deleteList($user_id, $list_id) {
            $db = $this->connect();

            try {
                $db->autocommit(FALSE);

                $query = "DELETE FROM items WHERE list_id=?";
                $query = $db->real_escape_string($query);

                if(!$stmt = $db->prepare($query)) {
                    throw new Exception($db->error);
                }

                $stmt->bind_param('i', $list_id);
                $stmt->execute();
                $stmt->close();

                $query = "DELETE FROM lists WHERE id=? AND owner=?";
                $query = $db->real_escape_string($query);

                if(!$stmt = $db->prepare($query)) {
                    throw new Exception($db->error);
                }

                $stmt->bind_param('ii', $list_id, $user_id);
                $stmt->execute();
                $stmt->close();

                $db->commit();

            } catch(Exception $e) {
                $db->rollback();
                $db->autocommit(TRUE);
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }

            $db->close();
        }

    }

}