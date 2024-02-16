<?php

require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Service/emailService.php';
require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Service/userSqs.php';
require_once '../Config/config.php';
require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);  
error_reporting(E_ALL);
ini_set("display_errors",true);
// if above line is enable catch block will execute for errors like giving duplicate values in insert query

   class UserModel{

       private $conn;

       private $message;

       public function __construct(){
         $config = new Config();
         $this->conn = $config->dbConnect();
       }

       public function getMessage(){
         return $this->message;
       }

       public function getUserByName($name,$role){
           try{
            //   $userType = "Customer";
              $query = "SELECT * FROM user WHERE user_name = ? AND user_type = ?";
              //mysqli_prepare() returns a statement object or false if an error occurred.
              $stmt = $this->conn->prepare($query); 
              if($stmt){
                  $stmt->bind_param("ss",$name,$role);
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
                     $this->message = "No Data found for ". $name;
                     Logger::log_api("No Data found for ". $name);
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

       public function getUserById($id){
         try{
            $query = "SELECT * FROM user WHERE id = ?";
            //mysqli_prepare() returns a statement object or false if an error occurred.
            $stmt = $this->conn->prepare($query); 
            if($stmt){
                $stmt->bind_param("s",$id);
                $stmt->execute();
                // get_result()-> Returns false on failure. 
                // For successful queries which produce a result set, such as SELECT, SHOW, DESCRIBE or EXPLAIN will return a mysqli_result object.
                $result = $stmt->get_result();
                if($result && $result->num_rows > 0){
                  /* fetch_assoc() -> Returns an associative array representing the fetched row, where each key in the array represents the name of 
                  one of the result set's columns, null if there are no more rows in the result set, or false on failure. */
                   $userData = $result->fetch_assoc();
                   return $userData;
                }else{
                   $stmt->close();
                   $this->conn->close();
                   $this->message = "No Data found for ". $id;
                   Logger::log_api("No Data found for ". $id);
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
               $password =  md5($userData['password']);
               $rePassword = md5($userData['rePassword']);
               $query = "INSERT INTO user(user_name,email,phone_number,password,re_password,user_type) VALUES(?,?,?,?,?,?)";
               $stmt = $this->conn->prepare($query);
               if($stmt){
                  $stmt->bind_param("ssisss",
                  $userData['userName'],
                  $userData['email'],
                  $userData['phoneNumber'],
                  $password,
                  $rePassword,
                  $userData['userType']
                  );
                 $stmt->execute();
                 if($stmt->affected_rows > 0){
                  $lastInsertedId = $this->conn->insert_id;
                  $userData2 = $this->getUserById($lastInsertedId);
                  $emailService = new EmailService();
                   if($emailService->sendEmail($userData2)){
                      Logger::log_api("Email sent successfully");
                   }else{
                     Logger::log_api("Email not sent");
                   }
                    return $userData2;
                 }else{
                    $stmt->close();
                    $this->conn->close();
                    Logger::log_api("Error inserting UserData Into DB");
                    return false;
                 }
               }else{
                  Logger::log_api("Errors in ".__FUNCTION__." : ".$this->conn->error);
                  $this->conn->close();
                  return false;
               }
            }catch(Throwable $th){
               Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
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
                    // AWS credentials and configuration   
                    $region = 'us-east-1';
                    $accessKeyId = 'AKIAXNGBMHCXRAGF6Q57';
                    $secretAccessKey = '7fD8ZlbuysjLahQJlZdxr6eZWcFwiyojWuTLMMXf';
                    $queueUrl = 'your-sqs-queue-url';

                    // Create SQSProcessor instance
                    $sqsProcessor = new SQSProcessor($region, $accessKeyId, $secretAccessKey);
                    $message = "User deleted.";

                    // Notify the user about the deletion
                    try {
                        $result = $sqsProcessor->sendMessage($queueUrl, $message);
                        
                    } catch (Exception $e) {
                        // Handle exceptions
                        Logger::log_api($e->getMessage());
                        return false;
                    }
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

       public function updateUserDetails($updatedCustomerData,$userId){
         try{
           $existingCustomerData = $this->getUserById($userId);
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
               $updateQuery .= " WHERE id = ?";
               $updateValues[] = $userId;

               $updateStmt = $this->conn->prepare($updateQuery);

               if ($updateStmt) {
                   $updateStmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
                   $updateStmt->execute();
                   if($updateStmt->affected_rows > 0){
                      return true;
                   }
                   else{
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
               return true;
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
              $password = md5($loginData['password']);
              $query = "SELECT * FROM user WHERE user_name = ? And password = ? AND user_type = ? ";
              $stmt = $this->conn->prepare($query);
              if($stmt){
                $stmt->bind_param("sss",$userName,$password,$userType);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result && $result->num_rows > 0){
                   $userData =  $result->fetch_assoc();
                   $this->message = "LogIn Successful. ";
                   return $userData;
                }else{
                   $this->message = "Invalid Credential. ";
                   $stmt->close();
                   $this->conn->close();
                   return false;
                }    
              }else{
                $this->message = "Internal Server Error";
                Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                $this->conn->close();
                return false;
              }
           } catch (Throwable $th) {
                $this->message = "Internal Server Error";
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
             Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
         }
       }

       public function getOwnerRoomBookingDetails($ownerId){
           try {
               $query = "SELECT * FROM room_booking WHERE room_room_id IN (SELECT r.room_id from room r where user_id = ?)";
               $stmt = $this->conn->prepare($query);
               if($stmt){
                    $stmt->bind_param("i",$ownerId);
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
            }catch (Throwable $th) {
              Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
            }
      }
       
      public function updateCustomerRoomBookingDetails($updatedData){
         try {
            $id = $updatedData['id'];
            $query = "SELECT * FROM room_booking WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            if($stmt){
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result && $result->num_rows > 0){
                     $existingData = $result->fetch_assoc();
                     if ($existingData) {
                        $updateFields = [];
                        foreach ($updatedData as $key => $value) {
                            if (array_key_exists($key, $existingData) && $existingData[$key] != $value) {
                                $updateFields[$key] = $value;
                            }
                        }
                        if (!empty($updateFields)) {
                           echo "inside1";
                           $updateQuery = "UPDATE room_booking SET ";
                           $updateValues = [];
            
                           foreach ($updateFields as $key => $value) {
                               $updateQuery .= "$key = ?, ";
                               $updateValues[] = $value;
                           }
            
                           $updateQuery = rtrim($updateQuery, ", ");
                           $updateQuery .= " WHERE id = ?";
                           $updateValues[] = $id;
                           $updateStmt = $this->conn->prepare($updateQuery);
            
                           if ($updateStmt) {
                               $updateStmt->bind_param(str_repeat("s", count($updateValues)), ...$updateValues);
                               $updateStmt->execute();
                               if($updateStmt->affected_rows > 0){
                                  return true;
                                 }else{
                                  $updateStmt->close();
                                  $this->conn->close();
                                  return false;
                                 }
                           }else{
                              Logger::log_api("Error in ".__FUNCTION__." : ".$this->conn->error);
                              $this->conn->close();
                              return false;
                           }
                        }else{
                           Logger::log_api("No updated values in : ".__FUNCTION__);
                           return true;
                        }
                       }else{
                        Logger::log_api("Customer data not found for : $id");
                          return false;
                       }
                     
                 }else{
                  echo "inside";
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

      public function insertRoomBookingDetails($bookingData,$customerId){
         try {
            $id=null;
             $query = "INSERT INTO room_booking(name,email,number,age,purpose,selected_gender,selected_room_size,select_id_types,
               select_laundry_types,select_catering_types,room_type,idnumber,check_in_date,check_out_date,check_in_time,
               check_out_time,user_id,room_room_id)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
             $stmt = $this->conn->prepare($query);
             if($stmt){
                $stmt->bind_param("ssiissssssssssssii",
                $bookingData['name'],
                $bookingData['email'],
                $bookingData['number'],
                $bookingData['age'],
                $bookingData['purpose'],
                $bookingData['selectedGender'],
                $bookingData['selectedRoomSize'],
                $bookingData['selectIdTypes'],
                $bookingData['selectLaundryTypes'],
                $bookingData['selectCateringTypes'],
                $bookingData['roomType'],
                $bookingData['idnumber'],
                $bookingData['checkInDate'],
                $bookingData['checkOutDate'],
                $bookingData['checkInTime'],
                $bookingData['checkOutTime'],
                $customerId,
                $id
               );
               $stmt->execute();
               if($stmt->affected_rows > 0){
                   return $bookingData;
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

      public function getRoomsBasedOnUser($roomType,$roomSize){
          try{
            $query = "SELECT * FROM room WHERE room_size = ? AND room_type = ?";
            $stmt = $this->conn->prepare($query);
            if($stmt){
                $stmt->bind_param("ss",$roomSize,$roomType);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
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
          }catch(Throwable $th){ 
             Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
          }
      }

      public function bookRoom($roomId,$userBookingData){
         try {
            // first select the bookings for the room based on the id.
            $query = "SELECT * FROM room_booking WHERE room_room_id = ?";
            $stmt = $this->conn->prepare($query);
            if($stmt){
               $stmt->bind_param("i",$roomId);
               $stmt->execute();
               $result = $stmt->get_result();
               if($result && $result->num_rows > 0){
                   $existingBookingDatas = $result->fetch_all(MYSQLI_ASSOC);
                     if($existingBookingDatas){
                       $userCheckInDate = $userBookingData['checkInDate'];
                       $userCheckOutDate = $userBookingData['checkOutDate'];
                       $isRoomAvailable = false;
                       foreach($existingBookingDatas as $existingBookingData){
                          $existingCheckInDate = $existingBookingData['check_in_date'];
                          $existingCheckOutDate = $existingBookingData['check_out_date'];
                          if($existingCheckInDate > $userCheckOutDate || $existingCheckOutDate < $userCheckInDate){
                             $isRoomAvailable = true;
                          }else{
                              $isRoomAvailable = false;
                              return;
                          } 
                        }
                        if($isRoomAvailable){
                           $updateQuery = "UPDATE room_booking SET room_room_id = ? WHERE name = ? AND email =?";
                           $updateStmt = $this->conn->prepare($updateQuery);
                           if($updateStmt){
                               $bookingName = $userBookingData['name'];
                               $bookingEmail = $userBookingData['email'];
                               $updateStmt->bind_param("iss",$roomId,$bookingName,$bookingEmail);
                               $updateStmt->execute();
                               if($updateStmt->affected_rows > 0){
                                  return true;
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
                        }else{
                           Logger::log_api("Error in ".__FUNCTION__." : Room Not Available");
                           return false;
                        }
                     } 
               }else{
                  $updateQuery = "UPDATE room_booking SET room_room_id = ? WHERE name = ? AND email = ?";
                  $updateStmt = $this->conn->prepare($updateQuery);
                  if($updateStmt){
                      $bookingName = $userBookingData['name'];
                      $bookingEmail = $userBookingData['email'];
                      $updateStmt->bind_param("iss",$roomId,$bookingName,$bookingEmail);
                      $updateStmt->execute();
                      if($updateStmt->affected_rows > 0){
                         return true;
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

      public function uploadImage($imageData,$data){
         try {
            $query = "INSERT INTO image(image,name) VALUES(?,?)";
            $stmt = $this->conn->prepare($query);
            if($stmt){
                $stmt->bind_param("ss",
                  $imageData,
                  $data
                );
                $stmt->execute();
                if($stmt->affected_rows > 0){
                   return true;
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

      public function getImage(){
         try {
             $name = 'sathish';
             $query = "SELECT * FROM image where name = ?";
             $stmt = $this->conn->prepare($query);
             if($stmt){
                $stmt->bind_param("s",$name);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result && $result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    $data['image'] = 'data:image/png;base64,' . base64_encode($data['image']);  
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
            Logger::log_api("Error in : ".__FUNCTION__." : ".$th->getMessage());
         }
      }

   }