<?php 

class MySQL {
    var $user = 'root';
    var $pass = DB_PASS;
    var $db = 'mobileapp';
    var $host = 'localhost';
    var $connection;
    var $error;

    public function MySQL() {
        if(!$this->databaselogincheck()) {
            $err = new ErrorHandler($this->error);
        }
    }

    function databaselogincheck() {
        $this->connection = mysql_connect($this->host, $this->user, $this->pass);

        if(!$this->connection) { 
            $this->error = "Database Login failed! Please make sure that the DB login credentials provided are correct";
            return false;
        }

        if(!mysql_select_db($this->db, $this->connection)) {
            $this->error = 'Failed to select database: '.$this->db.' Please make sure that the database name provided is correct';
            return false;
        }

        if(!mysql_query("SET NAMES 'UTF8'",$this->connection)) {
            $this->error = 'Error setting utf8 encoding';
            return false;
        }

        return true;
    }
    
    function query_db($query) {
        $result = mysql_query($query, $this->connection);

        if(!$result) {
            return false;
        } else {
            return mysql_fetch_assoc($result);
        }
    }

    function SanitizeForSQL($str) {
        if( function_exists( "mysql_real_escape_string" ) ) {
            $ret_str = mysql_real_escape_string( $str );
        } else {
            $ret_str = addslashes( $str );
        }
        return $ret_str;
    }

    function Sanitize($str,$remove_nl=true) {
        $str = $this->StripSlashes($str);

        if($remove_nl) {
            $injections = array('/(\n+)/i',
            '/(\r+)/i',
            '/(\t+)/i',
            '/(%0A+)/i',
            '/(%0D+)/i',
            '/(%08+)/i',
            '/(%09+)/i'
            );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }

    function StripSlashes($str) {
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return $str;
    }
}

?>