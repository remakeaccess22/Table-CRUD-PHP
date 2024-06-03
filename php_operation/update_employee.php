<?php
session_start();
require_once('../database/dbconnection.php');
$response = array();

$id=mysqli_real_escape_string($conn,$_POST['id']);
$fname=mysqli_real_escape_string($conn,$_POST['fname']);
$lname=mysqli_real_escape_string($conn,$_POST['lname']);
$email=mysqli_real_escape_string($conn,$_POST['email']);


 $status = "";
 $error = "";


 if($id=="" || $fname=="" || $lname=="" || $email==""){
   $status = "error";
   $error = "Empty Fields";
 }

 if($error==""){

   $sql = "UPDATE employees SET  first_name='$fname', last_name='$lname', email='$email' WHERE employee_id='$id' ";
   $query = $conn->query($sql);
    if($query){
     $status = "success";
     $error = "";
   }
   else {
     $status = "error";
     $error = "Cant edit data! Please try again!";
   }


 }


 $response[]=array(
         "status"=>($status),
         "error"=>($error)
         );


echo json_encode($response);

 
?>
