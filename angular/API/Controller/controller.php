<?php

    header("Access-Control-Allow-Origin: http://localhost");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");

   require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Model/userModel.php';
   require_once '/opt/lampp/htdocs/Mystudio_webapp/angular/API/Config/logger.php';

   error_reporting(E_ALL);
   ini_set("display_errors",true);

   class Controller{

    private $userModel;

    public function __construct(){
        $this->userModel = new UserModel();
    }

    public function getCustomerByName($userName){
        $customerData = $this->userModel->getCustomerByName($userName);
        if($customerData){
           $response = array(
            "status" => "success",
            "data" => $customerData
           ); 
           header("Content-Type: application/json");
           http_response_code(200);
           echo json_encode($response);
           Logger::log_api("Success response in : ".__FUNCTION__);
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

    public function getAllUserDetails(){
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

    public function insertUserDetails($userData){
        $isInserted = $this->userModel->insertUserDetails($userData);
        if($isInserted){
            $response = array(
                "status" => "Success",
                "message" => "UserData Inserted succesfully"
            );
            header("Content-Type: application/json");
            http_response_code(200);
            // echo json_encode($response);
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
            Logger::log_api("Error inserting UserData Into DB");
        }
    }

    public function userLogin($loginData){
      $userData = $this->userModel->userLogin($loginData);
      if($userData){
         $response = array(
            "status" => "Success",
            "message" => "Login Successful."
         );
         header("Content-Type: application/json");
         http_response_code(200);
         echo json_encode($response);
         Logger::log_api("User logged in successful.");
      }else{
          $response = array(
            "status" => "Error",
            "message" => "Invalid credential"
          );
          header("Content-Type: application/json");
          http_response_code(400);
          echo json_encode($response);
          Logger::log_api("Error : Invalid login credential.");
      }
    }

    public function deleteCustomerByName($userName){
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

    public function updateCustomerDetails($customerName,$updatedData){
        $isUpdated = $this->userModel->updateCustomerDetails($customerName,$updatedData);
        if($isUpdated){
             $response = array(
                "status" => "Success",
                "message" => "Customer Details Updated."
             );
             header("Content-Type: application/json");
             http_response_code(200);
             echo json_encode($response);
             Logger::log_api("Success Response : Customer data updated");
        }else{
            $response =array(
                "status" => "error",
                "message" => "Error in updating data."
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Error in updating customer data");
        }
    }

    public function getCustomerRoomBookingDetails($customerId){
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
   }

   $controller = new Controller();

   if($_SERVER['REQUEST_METHOD'] === 'GET'){ // to find the http method GEt
  
     $requestUri = $_SERVER['REQUEST_URI']; 
     if(strpos($requestUri,'/getCustomerByName') !==false){ // to find the endpoint 
         $userName = isset($_GET['name']) ? $_GET['name'] : null;
         if($userName == null){
            $response = array(
                "status" => "Error",
                "message" => "Invalid input in the URL"
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Invalid Parameter in ".$requestUri);
         }else{
            $controller->getCustomerByName($userName);
         }
     }else if(strpos($requestUri,'/getAllUser') !== false){
         $controller->getAllUserDetails();
     }else if(strpos($requestUri,'/getCustomerBookings') !== false){
         $customerId = isset($_GET['id']) ? $_GET['id'] : null;
         if($customerId == null){   //if id is not provided in the url
            $response = array(
                "status" => "Error",
                "message" => "Invalid input in the URL"
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Invalid Parameter in ".$requestUri);
         }else{
            $controller->getCustomerRoomBookingDetails($customerId);
         }
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
   }else if($_SERVER['REQUEST_METHOD'] === 'POST' && $_REQUEST['action'] ){// POST method
       $jsonData = file_get_contents('php://input');
       $data = json_decode($jsonData,true); 
       $action = $_REQUEST['action'];
   
       switch($action){
        case 'insertUser':{
            $controller->insertUserDetails($data);
            break;
        }
        case 'login':{
            $controller->userLogin($data);
            break;
        }
        default : {
            $response = array(
                "status" => "Error",
                "message" => "Unknown endpoint."
            );
            header("Content-Type: application/json");
            http_response_code(404);
            echo json_encode($response);
            Logger::log_api("Unknown Endpoint for POST URL : ".$requestUri);
        }
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
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData,true); 
        $requestUri = $_SERVER['REQUEST_URI'];
        $customerName = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
        if($customerName && $data){
            $controller->updateCustomerDetails($customerName,$data);
        }else{
            $response = array(
                "status" => "error",
                "message" => "Invalid input in URL"
            );
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode($response);
            Logger::log_api("Invalid input in url ".$requestUri);
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
?>