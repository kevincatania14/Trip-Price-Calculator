<?php namespace DataAccess\General;
    require_once("../../config.php");
    ini_set('max_execution_time', '300');

    class DbConn {   
        private $conn = null;

        function getConn() {
            return $this->conn;
        }
        
        function __construct() {
            $this->conn = new \mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

            if ($this->conn->error) {
                return "Error";
            }
        }
    }
?>