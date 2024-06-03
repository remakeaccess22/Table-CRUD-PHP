<?php
session_start();
require_once('../database/dbconnection.php');
$response = array();

$id=mysqli_real_escape_string($conn,$_POST['id']);


 $status = "";
 $error = "";


 if($id==""){
   $status = "error";
   $error = "Empty Fields";
 }

 if($error==""){

   $sql = "DELETE FROM employees WHERE employee_id='$id' ";
   $query = $conn->query($sql);
    if($query){
     $status = "success";
     $error = "";
   }
   else {
     $status = "error";
     $error = "Cant delete data! Please try again!";
   }


 }


 $response[]=array(
         "status"=>($status),
         "error"=>($error)
         );


echo json_encode($response);

 
?>
