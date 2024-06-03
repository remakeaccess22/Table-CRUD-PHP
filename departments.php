<?php
session_start();
require_once('database/dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="datatables/datatables.min.css">

</head>
<body>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <h5>Department Table</h5>
            </div>

            <div class="card-body">
                <table id="tblDepartment" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Department ID</th>
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
              
                </tbody>
            </table>

            </div>
        </div>
       
    </div>



<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="sweetalert/sweetalert2.all.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="datatables/datatables.min.js"></script>
<script>

$('#tblDepartment').DataTable();
fetchDepartments();
 
function fetchDepartments(){
    restartDatatable("#tblDepartment");
    $.ajax({
        type: "GET",
        url: "php_operation/getdepartments.php",
        dataType: "JSON",
        success: function(response){
            var len = response.length;
            var col = "";

            for(var i=0;i<len;i++){
                var department_id = response[i].department_id;
                var department_name = response[i].department_name;
                var manager_id = response[i].manager_id;
                var location_id = response[i].location_id;
                col+='<tr>';
                col+='<td> '+department_id+'</td>';
                col+='<td> '+department_name+'</td>';
                col+='<td> '+manager_id+'</td>';
                col+='<td> '+location_id+'</td>';
                col+='<td><a href="#" id="btnEdit" class="btn btn-warning btn-sm">EDIT</a> ';
                col+='<a href="#" id="btnDelete" class="btn btn-danger btn-sm">DELETE</a>';
                col+='</td>';
                col+='</tr>';
            }
            
            $('#tblDepartment tbody').append(col);  
            initDatable('#tblDepartment'); 
        }

    });



}
$(document).on('click','#btnDelete', function(){
    confirmDelete();

});

function deleteDepartment(){

}
function confirmDelete(){
    Swal.fire({
    icon: "question",
    title: "Do you want to delete this department?",
    showCancelButton: true,
    reverseButtons: true,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Yes, Delete",
    }).then((result) => {
        if (result.isConfirmed) {
           deleteDepartment();
       
        } 

    });
}


function initDatable(id){
    $(id).DataTable();
}
function restartDatatable(id){
    $(id).DataTable().destroy();
}

</script>
</body>
</html>