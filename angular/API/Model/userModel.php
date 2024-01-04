<?php

require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Service/emailService.php';
require_once '../Config/config.php';
require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  
error_reporting(E_ALL);
ini_set("display_errors",true);
// if above line is enable catch block will execute for errors like giving duplicate values in insert query

   class UserModel{

       private $conn;

       public function __construct(){
         $config = new Config();
         $this->conn = $config->dbConnect();
       }

       public function getCustomerByName($name){
           try{
              $userType = "Customer";
              $query = "SELECT * FROM user WHERE user_name = ? AND user_type = ?";
              //mysqli_prepare() returns a statement object or false if an error occurred.
              $stmt = $this->conn->prepare($query); 
              if($stmt){
                  $stmt->bind_param("ss",$name,$userType);
                  $stmt->execute();
                  // get_result()-> Returns false on failure. 
                  // For successful queries which produce a result set, such as SELECT, SHOW, DESCRIBE or EXPLAIN will return a mysqli_result object.
                  $result = $stmt->get_result();
                  if($result && $result->num_rows > 0){
                    /* fetch_assoc() -> Returns an associative array representing the fetched row, where each key in the array represents the name of 
                    one of the result set's columns, null if there are no more rows in the result set, or false on failure. */
                     $customerData = $result->fetch_assoc();
                     return $customerData;
                  }else{
                     $stmt->close();
                     $this->conn->close();
                     return false;
                  } 
              }else{
                // if statement object is not created than error will be occured
                Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                $this->conn->close();
                return false;
              }
              
           }catch(Throwable $e){
            // if any error occurs this block will execute.
            // errors like passing null value or improper value in bind_param.
              Logger::log_api("Error in : ".__FUNCTION__." : ".$e->getMessage());
           }
       }

       public function getAllUserDetails(){
         try{
            $query = "SELECT * FROM user";
            $result = $this->conn->query($query);
            if($result && $result->num_rows > 0){
                $userDatas = $result->fetch_all(MYSQLI_ASSOC);
                return $userDatas;
            }else{
              Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
              $this->conn->close();
              return false;
            }
         }catch(Throwable $e){
            Logger::log_api("Error in : ".__FUNCTION__." : ".$e->getMessage());
         }

       }

       public function insertUserDetails($userData){
            try{

               $query = "INSERT INTO user(user_name,email,phone_number,password,re_password,user_type) VALUES(?,?,?,?,?,?)";
               $stmt = $this->conn->prepare($query);
               if($stmt){
                  $stmt->bind_param("ssisss",
                  $userData['userName'],
                  $userData['email'],
                  $userData['phoneNumber'],
                  $userData['password'],
                  $userData['rePassword'],
                  $userData['userType']
               );
                 $stmt->execute();
                 if($stmt->affected_rows > 0){
                   $emailService = new EmailService();
                   if($emailService->sendEmail()){
                      Logger::log_api("Email sent successfully");
                   }else{
                     Logger::log_api("Email not sent");
                   }
                    return $userData;
                 }else{
                    $stmt->close();
                    $this->conn->close();
                    return false;
                 }
               }else{
                  Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                  $this->conn->close();
                  return false;
               }
            }catch(Throwable $th){
               Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
               // echo $th->getMessage();
            }
       }

       public function deleteCustomerByName($customerName){
          try {
            $userType = 'Customer';
            $query = "DELETE FROM user WHERE user_name = ? AND user_type = ?";
            $stmt = $this->conn->prepare($query);
            if($stmt){
                $stmt->bind_param("ss",$customerName,$userType);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                     return true;
                }else{
                  // if no data found for the given name this block will execute
                    $stmt->close();
                    $this->conn->close();
                    return false;
                }
            }else{
               Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
               $this->conn->clsoe();
               return false;
            }
            
          } catch (Throwable $th) {
            // if any error occurs this block will execute.
            // errors like passing null value or improper value in bind_param.
            Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
          }
       }

       public function updateCustomerDetails($customerName,$updatedCustomerData){
         try{
           $existingCustomerData = $this->getCustomerByName($customerName);
           if ($existingCustomerData) {
            $updateFields = [];
            foreach ($updatedCustomerData as $key => $value) {
                if (array_key_exists($key, $existingCustomerData) && $existingCustomerData[$key] !== $value) {
                    $updateFields[$key] = $value;
                }
            }
            if (!empty($updateFields)) {
               $updateQuery = "UPDATE user SET ";
               $updateValues = [];

               foreach ($updateFields as $key => $value) {
                   $updateQuery .= "$key = ?, ";
                   $updateValues[] = $value;
               }

               $updateQuery = rtrim($updateQuery, ", ");
               $updateQuery .= " WHERE user_name = ?";
               $updateValues[] = $customerName;

               $updateStmt = $this->conn->prepare($updateQuery);

               if ($updateStmt) {
                   $updateStmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
                   $updateStmt->execute();
                   if($updateStmt->affected_rows > 0){
                      return true;
                     }
                     if (!empty($updateFields)) {
                        $updateQuery = "UPDATE user SET ";
                        $updateValues = [];
                   }else{
                      $updateStmt->close();
                      $this->conn->close();
                      return false;
                   }
               }else{
                  Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                  $this->conn->clsoe();
                  return false;
               }
           }else{
               Logger::log_api("No updated values in : ".__FUNCTION__);
               return false;
           }
           }else{
            Logger::log_api("Customer data not found for : $customerName");
              return false;
           }
         }catch(Throwable $th){
            Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
         } 
         
       }

       public function userLogin($loginData){
           try {
              $userType = $loginData['userType'];
              $userName = $loginData['userName'];
              $password = $loginData['password'];
              $query = "SELECT * FROM user WHERE user_name = ? And password = ? AND user_type = ? ";
              $stmt = $this->conn->prepare($query);
              if($stmt){
                $stmt->bind_param("sss",$userName,$password,$userType);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result && $result->num_rows > 0){
                   $userData =  $result->fetch_assoc();
                   return $userData;
                }else{
                   $stmt->close();
                   $this->conn->close();
                   return false;
                }
                
              }else{
                Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                $this->conn->close();
                return false;
              }
           } catch (Throwable $th) {
                Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
           }
       }

       public function getCustomerRoomBookingDetails($customerID){
         try {
             $query = "SELECT * FROM room_booking WHERE user_id = ?";
             $stmt = $this->conn->prepare($query);
             if($stmt){
                 $stmt->bind_param("i",$customerID);
                 $stmt->execute();
                 $result = $stmt->get_result();
                 if($result && $result->num_rows > 0){
                     $data = $result->fetch_all(MYSQLI_ASSOC);
                     return $data;
                 }else{
                    $stmt->close();
                    $this->conn->close();
                    return false;
                 }
             }else{
               Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
               $this->conn->close();
               return false;
             }
         } catch (Throwable $th) {
       
         }
       }
   }

?>