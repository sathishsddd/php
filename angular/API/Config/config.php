<?php

require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';
error_reporting(0);

class Config{

    private $host = "localhost";
    private $userName = "root";
    private $password = "";
    private $database = "stay_flex";

    public function dbConnect(){    
        try{
            $conn = new mysqli($this->host,$this->userName,$this->password,$this->database);
            // connect_error -> Returns the error message from the last connection attempt.
            if($conn->connect_error){
                // if mysql server is down this block will execute
                throw new Exception("Connection error :".$conn->connect_error);
            }
            return $conn;
        }catch(Throwable $e){
            Logger::log_api($e->getMessage());
        }
    }
}

?>