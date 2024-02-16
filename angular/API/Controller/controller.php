<?php

    header("Access-Control-Allow-Origin: http://localhost");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET,POST,DELETE,PUT");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

   require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Model/userModel.php';
   require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

   error_reporting(E_ALL);
   ini_set("display_errors",true);

       // Set the session cookie parameters
       $sessionLifetime = 60*60*24; // lifetime in seconds for the session cookie stored in browser.
       session_set_cookie_params($sessionLifetime);

       // to set the session name(default:PHPSESSID)
       session_name("login");
       session_start(); 
 
      // ini_set('session.gc_maxlifetime', 1800); // Set the session lifetime to 30 minutes

      // Check if session timeout has occurred
      // The default session time in PHP is 24 minutes (1440 seconds).  
      $sessionTimeout = 60*60*24;
      if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > $sessionTimeout)) {
          // Session timeout, destroy the session in the server.
          session_unset();
          session_destroy();
      }

      $controller = new Controller();

      function trimArrayValues($value) {
       return trim($value);
      }
   
      if($_SERVER['REQUEST_METHOD'] === 'GET'){ // to find the http method GEt
        $requestUri = $_SERVER['REQUEST_URI']; 
        if(strpos($requestUri,'/getCustomerByName') !==false){ // to find the endpoint 
            $userName = isset($_GET['userName']) ? $_GET['userName'] : null;
            $role = isset($_GET['role']) ? $_GET['role'] : null;
            if($userName == null || $role == null){
               $response = array(
                   "status" => "Error",
                   "message" => "Invalid input in the URL"
               );
               header("Content-Type: application/json");
               http_response_code(400);
               echo json_encode($response);
               Logger::log_api("Invalid Parameter in ".$requestUri);
            }else{
               $controller->getUserByName($userName,$role);
            }
        }else if(strpos($requestUri,'/getAllUser') !== false){
            $controller->getAllUserDetails();
        }else if(strpos($requestUri,'/getCustomerBookings') !== false){
               $controller->getCustomerRoomBookingDetails();
         }else if(strpos($requestUri,'/getOwnerBookings') !== false){
               $controller->getOwnerRoomBookingDetails();
         }else if(strpos($requestUri,'/getRooms') !== false){
             $roomSize = isset($_GET['roomSize']) ? $_GET['roomSize'] : null;
             $roomType = isset($_GET['roomType']) ? $_GET['roomType'] : null;
             if($roomSize == null || $roomType == null){
               $response = array(
                   "status" => "Error",
                   "message" => "Invalid input in the URL"
               );
               header("Content-Type: application/json");
               http_response_code(400);
               echo json_encode($response);
               Logger::log_api("Invalid Parameter in ".$requestUri);
             }else{
                $controller->getRoomsBasedOnUser($roomType,$roomSize);
             }
         }else if(strpos($requestUri,'/logout') !== false){
             $controller->userLogout();
         }else if(strpos($requestUri,'/getImage') !== false){
             $controller->getImage();
         }else{
           $response = array(
               "status" => "Error",
               "message" => "Unknown endpoint."
           );
           header("Content-Type: application/json");
           http_response_code(404);
           echo json_encode($response);
           Logger::log_api("Unknown Endpoint for GET URL : ".$requestUri);
        }
      }else if($_SERVER['REQUEST_METHOD'] === 'POST'){// POST method
          $jsonData = file_get_contents('php://input');
          $data = json_decode($jsonData,true);
        if ($data && isset($_REQUEST['action'])) {
          $trimmedData = array_map('trimArrayValues', $data);
          $action = $_REQUEST['action'];
          switch($action){
           case 'insertUser':{
               $controller->insertUserDetails($trimmedData);
               break;
           }
           case 'login':{
               $controller->userLogin($trimmedData);
               break;
           }
           case 'updateCustomerBookings':{
               $controller->updateCustomerRoomBookingDetails($trimmedData);
               break;
           }
           case 'insertBookingDetails':{
               $userId = $_REQUEST['id'];
               $controller->insertRoomBookingDetails($trimmedData,$userId);
               break;
           }
           case 'bookRoom': {
               $roomId = $_REQUEST['roomId'];
               $controller->bookRoom($roomId,$trimmedData);
               break;
           }
           // case 'image': {
           //     $jsonData = $_POST["data"];
           //     $data = json_decode($jsonData,true);
           //     print_r($data);
           //     if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
           //         $imageData = file_get_contents($_FILES['image']['tmp_name']);
           //         echo $imageData;
           //     }
           //     $controller->uploadImage($imageData,$data);
           //     break;
           // }
           default : {
               $response = array(
                   "status" => "Error",
                   "message" => "Unknown endpoint."
               );
               header("Content-Type: application/json");
               http_response_code(404);
               echo json_encode($response);
               Logger::log_api("Unknown Endpoint for POST URL : ".$_SERVER['REQUEST_URI']);
           }
         }
       }else{
             $response = array(
                "status" => "Error",
                "message" => "Invalid input in URL."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Invalid input in url ".$_SERVER['REQUEST_URI']);
       }
      }else if($_SERVER['REQUEST_METHOD'] === 'DELETE'){// DELETE method
           $requestUri = $_SERVER['REQUEST_URI'];
           if(strpos($requestUri,'/deleteCustomer') !== false){
                $userName = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
                if($userName == null){
                  $response = array(
                   "status" => "error",
                   "message" => "Invalid input in the URL"
                  );
                  header("Content-Type: application/json");
                  http_response_code(400);
                  echo json_encode($response);
                  Logger::log_api("Invalid parameter in ".$requestUri);
                }else{
                   $controller->deleteCustomerByName($userName);
                }
           }else{
               $response = array(
                   "status" => "Error",
                   "message" => "Unknown endpoint."
               );
               header("Content-Type: application/json");
               http_response_code(404);
               echo json_encode($response);
               Logger::log_api("Unknown Endpoint for DELETE URL : ".$requestUri);
           }
      }else if($_SERVER['REQUEST_METHOD'] === 'PUT'){ // PUT method
            $requestUri = $_SERVER['REQUEST_URI'];
          if (strpos($requestUri,'/updateUser') !== false) {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData,true);
            if($data){
                $trimmedData = array_map('trimArrayValues', $data);
                $controller->updateUserDetails($trimmedData);
            }else{
                $response = array(
                    "status" => "error",
                    "message" => "No data to update."
                );
                header("Content-Type: application/json");
                http_response_code(400);
                echo json_encode($response);
                Logger::log_api("Empty body in url ".$requestUri);
            }
          }else{
            $response = array(
                "status" => "Error",
                "message" => "Unknown endpoint."
            );
            header("Content-Type: application/json");
            http_response_code(404);
            echo json_encode($response);
            Logger::log_api("Unknown Endpoint for PUT URL : ".$requestUri);
          }
           
      }else{
       $response = array(
           "status" => "Error",
           "message" => "Unknown Request Method."
       );
       header("Content-Type: application/json");
       http_response_code(405);
       echo json_encode($response);
       Logger::log_api("Invalid Request method : ".$_SERVER['REQUEST_METHOD']);
      }

   class Controller{

    private $userModel;

    public function __construct(){
        $this->userModel = new UserModel();
    }

    private function validateSession(){
        if(!isset($_SESSION['userId'])){
            $response = array(
                "status" => "error",
                "message" => "Session Expired. Please Login."
            );
            header("Content-Type: application/json");
            http_response_code(401); // Unauthenticated
            echo json_encode($response);
            exit();
        }
    }

    private function validateSessionAndRoleForOwner($role){
        $this->validateSession();
        if($role !== $_SESSION['role']){
            $response = array(
                "status" => "error",
                "message" => "Unauthorized Access, Please Login as Owner."
            );
            header("Content-Type: application/json");
            http_response_code(403); // forbidden
            echo json_encode($response);
            exit();
        }
    }

    private function validateSessionAndRoleForCustomer($role){
        $this->validateSession();
        if($role !== $_SESSION['role']){
            $response = array(
                "status" => "error",
                "message" => "Unauthorized Access, Please Login as Customer."
            );
            header("Content-Type: application/json");
            http_response_code(403); // forbidden
            echo json_encode($response);
            exit();
        }
    }

    public function getUserByName($userName,$role){
        $customerData = $this->userModel->getUserByName($userName,$role);
        if(!$customerData){
           $response = array(
            "status" => "success",
            "data" => $customerData
           ); 
           header("Content-Type: application/json");
           http_response_code(200);
           echo json_encode($response);
           Logger::log_api("Success response in : ".__FUNCTION__);
        }else{
            // $message = $this->userModel->getMessage();
            $response = array(
              "status" => "Error",
              "data" => $customerData
            );
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($response);
        }
    }

    public function getAllUserDetails(){
        $this->validateSession();
        $userDatas = $this->userModel->getAllUserDetails();
        if($userDatas){
            $response = array(
                "status" => "success",
                "data" => $userDatas
               );
               header("Content-Type: application/json");
               http_response_code(200);
               echo json_encode($response);
               Logger::log_api("Success response in : ".__FUNCTION__);
        }else{
            $response = array(
                "status" => "Error",
                "message" => "No Data Available"
              );
              header("Content-Type: application/json");
              http_response_code(400);
              echo json_encode($response);
              Logger::log_api("No Data Available in : ".__FUNCTION__);
        }
    }

    private function validateInsertDetails($userData){
        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $response = array(
                "status" => "Error",
                "message" => "Invalid Email Format."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            // Logger::log_api("Invalid Email Format in Insert details");
            exit();
        }else{
            $response = array(
                "status" => "Success",
                "message" => "valid Email Format."
            );
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($response);
            exit();
        }
    }
    
    public function insertUserDetails($userData){
        $this->validateInsertDetails($userData);
        $isInserted = $this->userModel->insertUserDetails($userData);
        if($isInserted){
            $response = array(
                "status" => "Success",
                "message" => "UserData Inserted succesfully"
            );
            header("Content-Type: application/json");
            http_response_code(200);
            // echo json_encode($response);/
            echo json_encode($isInserted);
            Logger::log_api("UserData inserted Into DB");
        }else{
            $response = array(
                "status" => "Error",
                "message" => "UserData Not Inserted in DB"
            );  
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);     
        }
    }

    public function userLogin($loginData){
      $userData = $this->userModel->userLogin($loginData);
      $message = $this->userModel->getMessage();
      if($userData){
        //  session_start();
        //new session id need to be created if different user signed in from the same browser and same machine.
        session_regenerate_id(true);
         $_SESSION['userId'] = $userData['id'];
         $_SESSION['role'] = $userData['user_type'];
         $_SESSION['start'] = time();
         $response = array(
            "status" => "Success",
            "message" => $message,
            "data" => $userData
         );
         header("Content-Type: application/json");
         http_response_code(200);
         echo json_encode($response,JSON_PARTIAL_OUTPUT_ON_ERROR);
         Logger::log_api("User logged in successful.");
      }else{
          $response = array(
            "status" => "Error",
            "message" => $message
          );
          header("Content-Type: application/json");
          http_response_code(400);
          echo json_encode($response);
          Logger::log_api("Error : Invalid login credential.");
      }
    }

    public function userLogout(){
        $this->validateSession();
        session_destroy();
        http_response_code(200);
        echo json_encode(['staus' => 'Success']);
        Logger::log_api("Logout successful.");      
    }

    public function deleteCustomerByName($userName){
        $this->validateSession();
        $isDeleted = $this->userModel->deleteCustomerByName($userName);
        if($isDeleted){
          $response = array(
            "status" => "Success",
            "message" => "User Deleted."
          );
          header("Content-Type: application/json");
          http_response_code(200);
          echo json_encode($response);
          Logger::log_api("User data deleted for UserName : ".$userName." in ".__FUNCTION__);
        }else{
            $response = array(
                "status" => "Error",
                "message" => "User data not found"
              );
              header("Content-Type: application/json");
              http_response_code(400);
              echo json_encode($response);
              Logger::log_api("User data not found in : ".__FUNCTION__);
        }
    }

    public function updateUserDetails($updatedData){
        $this->validateSession();
        $userId = $_SESSION['userId'];
        $isUpdated = $this->userModel->updateUserDetails($updatedData,$userId);
        if($isUpdated){
             $response = array(
                "status" => "Success",
                "message" => "User Details Updated."
             );
             header("Content-Type: application/json");
             http_response_code(200);
             echo json_encode($response);
             Logger::log_api("Success Response : user data updated");
        }else{
            $response =array(
                "status" => "error",
                "message" => "Error in updating data."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Error in updating user data");
        }
    }

    public function getCustomerRoomBookingDetails(){
       $this->validateSessionAndRoleForCustomer("Customer");
       $customerId = $_SESSION['userId'];
       $data = $this->userModel->getCustomerRoomBookingDetails($customerId);
       if($data){
          header("Content-Type: application/json");
          http_response_code(200);
          echo json_encode($data);
          Logger::log_api("Success Response in getting booking details");
       }else{
        $response =array(
            "status" => "error",
            "message" => "Error in getting  booking data."
        );
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode($response);
        Logger::log_api("Error in getting booking data");
       }
    }

    public function getOwnerRoomBookingDetails(){
        $this->validateSessionAndRoleForOwner("Owner");
        $ownerId = $_SESSION['userId'];
        $data = $this->userModel->getOwnerRoomBookingDetails($ownerId);
        if($data){
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($data);
            Logger::log_api("Success Response in getting booking details");
        }else{
            $response =array(
                "status" => "error",
                "message" => "Error in getting  booking data."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Error in getting booking data");
        }
    }

    public function updateCustomerRoomBookingDetails($updatedData){
        $this->validateSession();
        $isUpdated = $this->userModel->updateCustomerRoomBookingDetails($updatedData);
        if($isUpdated){
          $response = array(
            "status" => "Sucess",
            "message" => "Data Updated Successfully."
          );    
          header("Content-Type: application/json");
          http_response_code(200);
          echo json_encode($response);
          Logger::log_api("Success Response in updating booking details");
        }else{
            $response = array(
                "status" => "Error",
                "message" => "Error in updating data."
            );
              header("Content-Type: application/json");
              http_response_code(400);
              echo json_encode($response);
              Logger::log_api("Error Response in updating booking details");
        }
    }

    public function insertRoomBookingDetails($bookingData,$customerId){
        $this->validateSession();
        $data = $this->userModel->insertRoomBookingDetails($bookingData,$customerId);
        if($data){
            $response = array(
                "status" => "Sucess",
                "message" => "Data Updated Successfully.",
                "data" => $data
              );
              header("Content-Type: application/json");
              http_response_code(200);
              echo json_encode($response);
              Logger::log_api("Success Response in updating booking details");
        }else{
            $response = array(
                "status" => "Error",
                "message" => "Error in inserting booking data."
            );
              header("Content-Type: application/json");
              http_response_code(400);
              echo json_encode($response);
              Logger::log_api("Error in inserting booking details");
        }
    }

    public function getRoomsBasedOnUser($roomType,$roomSize){
        $data = $this->userModel->getRoomsBasedOnUser($roomType,$roomSize);
        if($data){
              header("Content-Type: application/json");
              http_response_code(200);
              echo json_encode($data);
              Logger::log_api("Success Response in getting room details");
        }else{
            $response = array(
                "status" => "Error",
                "message" => "Error in getting room details."
            );
              header("Content-Type: application/json");
              http_response_code(400);
              echo json_encode($response);
              Logger::log_api("Error in getting room details");
        }
    }

    public function bookRoom($roomId,$userBookingData){
       $result = $this->userModel->bookRoom($roomId,$userBookingData);
       if($result){
             $response = array(
                "status" => "Success",
                "message" => "Room Booked Successfully."
             );
             header("Content-Type: application/json");
             http_response_code(200);
             echo json_encode($response);
             Logger::log_api("Room Booked Successfully");
       }else{
            $response = array(
                "status" => "Error",
                "message" => "Room not available."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Room not available.");
       }
    }

    public function uploadImage($imageData,$data){
       $result = $this->userModel->uploadImage($imageData,$data);
       if($result){
        $response = array(
            "status" => "Success",
            "message" => "Image uploaded Successfully."
         );
         header("Content-Type: application/json");
         http_response_code(200);
         echo json_encode($response);
         Logger::log_api("Image uploaded Successfully");
       }else{
        $response = array(
            "status" => "Error",
            "message" => "Error in uploading image."
         );
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode($response);
        Logger::log_api("Error in uploading image.");
       }
    }

    public function getImage(){
        $result = $this->userModel->getImage();
        if($result){
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($result);
            Logger::log_api("Image retreived Successfully");
        }else{
            $response = array(
                "status" => "Error",
                "message" => "Error in retreiving image."
             );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Error in retreiving image.");
        }
    }
    
   }

?>