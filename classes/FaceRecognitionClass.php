<?php

require_once "../FaceRecognition.php";

class Face {

    function uploadFace () {
        if($_SERVER['REQUEST_METHOD'] == "POST") {            
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);

            if (true) {  //some security check
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    if (file_exists("upload/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " already exists. ";
                    } else {
                        $uploadURL = "upload/" . $_FILES["file"]["name"];
                        $upload = move_uploaded_file($_FILES["file"]["tmp_name"], $uploadURL);
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
                                print_r(json_encode($response->body));
                            } catch (Exception $e) {
                                print $e;
                            }
                        }
                    }
                }
            }
        }
    }
}

?>
