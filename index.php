<?php
session_start();
require_once('database/dbconnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datatable Sample</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="datatables/datatables.min.css">

</head>

<body>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <h5>Employee Table</h5>
            </div>

            <div class="card-body">
                <a href="#" class="btn btn-primary btn-sm" id="btnAdd">+ ADD EMPLOYEE</a>
                <table id="table1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $sql = "SELECT * FROM employees";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                        $employee_id = $row['employee_id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $email = $row['email'];
                        $name = $first_name." ".$last_name;
                    ?>
                        <tr>
                            <td> <?php echo $employee_id; ?> </td>
                            <td> <?php echo $name; ?> </td>
                            <td> <?php echo $email; ?> </td>
                            <td>
                                <a href="#" id="btnEdit" data-id="<?php echo $employee_id;?>"
                                    data-first_name="<?php echo $first_name;?>"
                                    data-last_name="<?php echo $last_name;?>" data-email="<?php echo $email;?>"
                                    class="btn btn-warning btn-sm">EDIT</a>
                                <a href="#" id="btnDelete" data-id="<?php echo $employee_id;?>"
                                    class="btn btn-danger btn-sm">DELETE</a>
                            </td>
                        </tr>

                        <?php           
                    }
                ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Employee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <label for="txtFname">Enter firstname:</label>
                    <input type="text" id="txtFname" class="form-control">

                    <label for="txtLname">Enter lastname:</label>
                    <input type="text" id="txtLname" class="form-control">

                    <label for="txtEmail">Enter email:</label>
                    <input type="email" id="txtEmail" class="form-control">


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btnSave">Save</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Employee</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <input type="hidden" id="e_emp_id">
                    <label for="e_txtFname">Enter firstname:</label>
                    <input type="text" id="e_txtFname" class="form-control">

                    <label for="e_txtLname">Enter lastname:</label>
                    <input type="text" id="e_txtLname" class="form-control">

                    <label for="e_txtEmail">Enter email:</label>
                    <input type="email" id="e_txtEmail" class="form-control">


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btnUpdate">Update</button>
                </div>

            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="sweetalert/sweetalert2.all.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="datatables/datatables.min.js"></script>
    <script>
    $('#table1').DataTable();

    $(document).on('click', '#btnDelete', function() {
        var id = $(this).data('id');
        confirmDelete(id);

    });
    $(document).on('click', '#btnEdit', function() {
        //get data values from the button edit
        var id = $(this).data('id');
        var first_name = $(this).data('first_name');
        var last_name = $(this).data('last_name');
        var email = $(this).data('email');

        //set the values of the fields in modal edit
        $('#e_emp_id').val(id);
        $('#e_txtFname').val(first_name);
        $('#e_txtLname').val(last_name);
        $('#e_txtEmail').val(email);

        //show modal
        $('#modalEdit').modal('show');

    });
    $(document).on('click', '#btnAdd', function() {
        $('#modalAdd').modal('show');

    });
    $(document).on('click', '#btnUpdate', function() {
        confirmEdit();

    });
    $(document).on('click', '#btnSave', function() {
        confirmAdd();

    });

    function deleteEmployee(id) {
        //set as object
        var values = {
            "id": id
        }

        $.ajax({
            type: "POST",
            url: "php_operation/delete_employee.php",
            data: values,
            dataType: 'JSON',
            success: function(response) {
                var status = response[0].status;
                var error = response[0].error;

                if (status == "success") showAlert('success', 'Success', 'Employee deleted');
                if (status == "error") showAlert('error', 'Error', error);

            }

        });

    }

    function updateEmployee() {
        var id = $('#e_emp_id').val();
        var fname = $('#e_txtFname').val();
        var lname = $('#e_txtLname').val();
        var email = $('#e_txtEmail').val();

        //check if empty
        if (fname == "") {
            showAlert('error', 'Empty Fields', 'Please enter firstname! ');
            return;
        }
        if (lname == "") {
            showAlert('error', 'Empty Fields', 'Please enter lastname! ');
            return;
        }
        if (email == "") {
            showAlert('error', 'Empty Fields', 'Please enter email! ');
            return;
        }


        //set as object
        var values = {
            "id": id,
            "fname": fname,
            "lname": lname,
            "email": email
        }

        $.ajax({
            type: "POST",
            url: "php_operation/update_employee.php",
            data: values,
            dataType: 'JSON',
            success: function(response) {
                var status = response[0].status;
                var error = response[0].error;

                if (status == "success") showAlert('success', 'Success', 'Employee updated!');
                if (status == "error") showAlert('error', 'Error', error);

            }

        });

    }

    function addEmployee() {
        var fname = $('#txtFname').val();
        var lname = $('#txtLname').val();
        var email = $('#txtEmail').val();

        //check if empty
        if (fname == "") {
            showAlert('error', 'Empty Fields', 'Please enter firstname! ');
            return;
        }
        if (lname == "") {
            showAlert('error', 'Empty Fields', 'Please enter lastname! ');
            return;
        }
        if (email == "") {
            showAlert('error', 'Empty Fields', 'Please enter email! ');
            return;
        }


        //set as object
        var values = {
            "fname": fname,
            "lname": lname,
            "email": email
        }

        $.ajax({
            type: "POST",
            url: "php_operation/add_employee.php",
            data: values,
            dataType: 'JSON',
            success: function(response) {
                var status = response[0].status;
                var error = response[0].error;

                if (status == "success") showAlert('success', 'Success', 'Employee added!');
                if (status == "error") showAlert('error', 'Error', error);

            }

        });

    }

    function confirmDelete(id) {
        Swal.fire({
            icon: "question",
            title: "Do you want to delete this employee?",
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yes, Delete It",
        }).then((result) => {
            if (result.isConfirmed) {
                deleteEmployee(id);

            }

        });
    }

    function confirmEdit() {
        Swal.fire({
            icon: "question",
            title: "Do you want to update this employee?",
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yes, Update It",
        }).then((result) => {
            if (result.isConfirmed) {
                updateEmployee();

            }

        });
    }

    function confirmAdd() {
        Swal.fire({
            icon: "question",
            title: "Do you want to add a new employee?",
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yes, Add It",
        }).then((result) => {
            if (result.isConfirmed) {
                addEmployee();

            }

        });
    }

    function showAlert(icon, title, content) {
        Swal.fire({
            icon: icon,
            title: title,
            text: content,
            confirmButtonText: 'CONTINUE',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then((result) => {

            if (result.isConfirmed) {
                if (icon == 'success')
                    location.reload(true); //reload the page


            }
        });


    }
    </script>
</body>

</html>