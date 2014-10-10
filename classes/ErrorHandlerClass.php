<?php

class ErrorHandler {
    public function ErrorHandler($error) {
        print '{"error": true, "description": "' . $error . '"}';
        exit();
    }
}

?>