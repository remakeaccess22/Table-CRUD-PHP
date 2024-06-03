<?php
session_start();
require_once('../database/dbconnection.php');
?>

<?php
$response = array();

$fname=mysqli_real_escape_string($conn,$_POST['fname']);
$lname=mysqli_real_escape_string($conn,$_POST['lname']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
 
 
 $status = "";
 $error = "";


 if($fname=="" || $lname=="" || $email==""){
   $status = "error";
   $error = "Empty Fields";
 }

 if($error==""){

   $sql = "INSERT INTO employees(first_name,last_name,email) VALUES('$fname','$lname','$email')";
   $query = $conn->query($sql);
    if($query){
     $status = "success";
     $error = "";
   }
   else {
     $status = "error";
     $error = "Cant add data! Please try again!";
   }


 }


 $response[]=array(
         "status"=>($status),
         "error"=>($error)
         );


echo json_encode($response);

 
?>