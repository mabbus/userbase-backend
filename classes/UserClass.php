<?php

class User {
    var $db;

    public function User() {
        $this->db = new MySQL();
    }

    function getUserInfo($id, $field) {
        session_start();
        //check session
        if(isset($_SESSION["uid"])) {
            $field = "uid";
            $id = $_SESSION["uid"];
        }

        //limit to uid and fid         
        if($field == "uid" || $field == "fid") {
            $query = "select * from users where " . $field . " = '" . $this->db->SanitizeForSQL($id) . "'";
            $result = $this->db->query_db($query);
            if($result) {
                $result['exists'] = true;
                $faceImageObj = new Face();
                $faceImage = $faceImageObj->getImageByUID($result["uid"]);

                if($faceImage) {
                    $result["faceProcessed"] = 1;
                    $result["face"] = $faceImage["data"];
                }

                $this->updateLogin($result['uid']);
                $user = json_encode($result);
                $this->createSession($result['uid']);
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
        //TODO: GET USER INFO FROM FB
        $query = "insert into users values('', '" . $this->db->SanitizeForSQL($fid) . "', 'randomemail@gmail.com', 'temetito', 'elgordo', '" . time() . "', false)";
        $result = $this->db->query_db($query);
        $uid = mysql_insert_id();

        if($uid > 0) {
            $this->createSession($uid);
            $this->getUserInfo($uid, 'uid');
        } else {
            $error = new ErrorHandler('Problem creating user');
        }
    }

    function createSession($uid) {
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["uid"] = $uid;
    }

    function updateUser($uid) {
        
    }

    function deleteUser($uid) {

    }

}

?>