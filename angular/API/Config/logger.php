<?php

class Logger{

    public static function log_api($message){
        date_default_timezone_set('Asia/Kolkata');
          // Define the log file path
          $logFilePath = '/opt/lampp/htdocs/Mystudio_webapp/angular/API/api_logs.txt';

          // Get the current date and time
          $dateTime = new DateTime();
          $timestamp = $dateTime->format('Y-m-d H:i:s');

          // Construct the log message
          $logMessage = "[$timestamp] $message" . PHP_EOL;
  
          // Append the log message to the log file
          file_put_contents($logFilePath, $logMessage, FILE_APPEND);
    }
}
?>