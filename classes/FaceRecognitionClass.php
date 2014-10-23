<?php

require_once "../FaceRecognition.php"; //SETS CONSTANT FOR API KEY

class Face {

    var $hash;
    
    public function Face () {
        $this->db = new MySQL();
    }

    function uploadFace () {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $allowedExts = array("gif", "jpeg", "jpg", "png"); //todo
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
                    require_once 'classes/SymmetryCalculator.php';
                    $sym = new SymmetryCalculator($response->body->faces[0]->landmarks);
                    $percentage = $sym->calculatePercentage();
                    $this->insertFile($response->body->faces[0], $percentage);
                    $response->body->image = (array)$response->body->image;
                    $response->body->image['fileUrl'] = "rest/upload/" . $_FILES["file"]["name"];
                    $response->body->image['percentage'] = $percentage;
                    $response->body->image = (object)$response->body->image;

                    print_r(json_encode($response->body));

                } else {
                    $err = new ErrorHandler('No face detected');
                }
            } catch (Exception $e) {
                print $e;
            }
        }
    }

    function insertFile($data, $percentage) {

        /*NEEDS A DB UPDATE TO SET PREVIOUS IMAGES TO NOT ACTIVE*/

        if(!isset($_SESSION)) {
            session_start();
        }
        $query = "insert into symmetryFiles (hid,uid,fileName,data,active, percentage) values('" . $this->hash . "','" . $_SESSION["uid"] . "','" . $_FILES["file"]["name"] . "','" . "234" . "', 1,'" . $percentage . "')";
        $result = $this->db->query_db($query);        
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
