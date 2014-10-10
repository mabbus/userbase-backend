<?php

require_once 'classes/MysqlClass.php';

class User {
    var $db;

    public function User() {
        $this->db = new MySQL();
    }

    function getUserInfo($id, $field) {
        $query = "select * from users where " . $field . " = '" . $this->db->SanitizeForSQL($id) . "'";
        $result = $this->db->query_db($query);

        if($result) {
            $result['exists'] = true;
            $user = json_encode($result);
            print $user;
        } else {
            print '{"exists" : false}';
        }
    }

    function createUser($fid) {
        $query = "insert into users values('', '" . $this->db->SanitizeForSQL($fid) . "', 'randomemail@gmail.com', 'temetito', 'elgordo', '" . time() . "')";
        $result = $this->db->query_db($query);
        $uid = mysql_insert_id();

        if($uid > 0) {
            $this->getUserInfo($uid, 'uid');
        } else {
            $error = new ErrorHandler('Problem creating user');
        }
    }

}

?>