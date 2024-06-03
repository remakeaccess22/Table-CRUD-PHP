<?php 
session_start();
require_once('../database/dbconnection.php');
$response = array();

$sql = "SELECT * FROM departments";
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){
    $department_id = $row['department_id'];
    $department_name = $row['department_name'];
    $manager_id = $row['manager_id'];
    $location_id = $row['location_id'];

    $response[]= array(
        "department_id"=>$department_id,
        "department_name"=>$department_name,
        "manager_id"=>$manager_id,
        "location_id"=>$location_id
    );

}

echo json_encode($response);



?>