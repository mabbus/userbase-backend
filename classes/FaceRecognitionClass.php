<?php

require_once "../FaceRecognition.php";

class Face {

    var $hash;
    
    public function Face () {
        $this->db = new MySQL();
    }

    function uploadFace () {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            $uploadURL = "upload/" . $_FILES["file"]["name"];
            $upload = move_uploaded_file($_FILES["file"]["tmp_name"], $uploadURL);


            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
                if (file_exists($_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " already exists. ";
                } else {
                    $this->hash = (md5_file("upload/" . $_FILES["file"]["name"]));
                    $image = $this->getImageByHash();
                    if($image) {
                        print $image['data'];
                    } else {
                        $this->addFile($upload);
                    }
                }
            }
        }
    }

    function getImageByUID ($uid) {
        $query = "select * from symmetryFiles where uid = '" . $uid . "'";
        $result = $this->db->query_db($query);

        if($result) {
            return $result;
        } else {
            return false;
        }
        
    }

    function addFile ($upload) {
        if($upload) {
            require_once 'unirest-php/lib/Unirest.php';
            try {
                $response = Unirest::post("https://apicloud-facemark.p.mashape.com/process-file.json",
                array(
                    "X-Mashape-Key" => API_KEY
                ),
                array(
                    "image" => Unirest::file("upload/" . $_FILES["file"]["name"])
                                    )
                );
                
                if(count($response->body->faces) > 0) {
                    $this->insertFile($response->body->faces);
                    print_r(json_encode($response->body));
                } else {
                    $err = new ErrorHandler('No face detected');
                }
            } catch (Exception $e) {
                print $e;
            }
        }
    }

    function insertFile($data) {
        if(!isset($_SESSION)) {
            session_start();
        }
        $query = "insert into symmetryFiles (hid,uid,fileName,data,active) values('" . $this->hash . "','" . $_SESSION["uid"] . "','" . $_FILES["file"]["name"] . "','" . json_encode($data) . "', 1)";
        $result = $this->db->query_db($query);

        if(!$result) {
            error_log("Couldn't insert file " . $_FILES["file"]["name"] . " into db from user " . $_SESSION["uid"], 0);
        }
        
    }

    function getImageByHash () {
        $query = "select * from symmetryFiles where hid = '" . $this->hash . "'";
        $result = $this->db->query_db($query);

        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}

?>
