<?php

require_once 'classes/MysqlClass.php';

class User {
    var $db;

    public function User() {
        $this->db = new MySQL();
    }

    function getUserInfo($id, $field) {
        //limit to uid and fid 
        if($field == "uid" || $field == "fid") {
            $query = "select * from users where " . $field . " = '" . $this->db->SanitizeForSQL($id) . "'";
            $result = $this->db->query_db($query);

            if($result) {
                $result['exists'] = true;
                $this->updateLogin($result['uid']);
                $user = json_encode($result);
                print $user;
            } else {
                print '{"exists" : false}';
            }
        }
    }

    function updateLogin($id) {
        $query = "update users set lastLogin = '" . time() . "'";
        $result = $this->db->query_db($query);
    }

    function createUser($fid) {
        $query = "insert into users values('', '" . $this->db->SanitizeForSQL($fid) . "', 'randomemail@gmail.com', 'temetito', 'elgordo', '" . time() . "', false)";
        $result = $this->db->query_db($query);
        $uid = mysql_insert_id();

        if($uid > 0) {
            $this->getUserInfo($uid, 'uid');
        } else {
            $error = new ErrorHandler('Problem creating user');
        }
    }

    function updateUser($uid) {

    }

    function deleteUser($uid) {

    }

}

?>