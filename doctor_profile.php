<?php
session_start();

if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}
date_default_timezone_set('Asia/Kolkata');
require_once 'config/connection.php';


if (isset($_POST['add'])) {
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $phone_no = $_POST['Phone_No']; 
    $designation = $_POST['Designation'];
    $qualification = $_POST['Qualification'];
    $username = $_POST['Username']; 
    $password = $_POST['password'];
    $date = date('Y-m-d');

    if (mysqli_query($conn, "INSERT INTO doctor (Name, Designation, Qualification, email, Phone_No, Username, Date_created) 
                             VALUES ('$name', '$designation', '$qualification', '$email', '$phone_no', '$username', '$date')")) {

            if (mysqli_query($conn, "INSERT INTO user_creation (username, password, email, usertype) 
                    VALUES ('$username', '$password', '$email', 'Doctors')")) {
            echo "<script>alert('Doctor added successfully.');location.href='doctor_profile.php';</script>";
        } else { 
            echo "<script>alert('Unable to add Doctor.');location.href='doctor_profile.php';</script>";
        }
    }
}

if (isset($_POST['update'])) {
    $name = $_POST['Name'];
    $designation = $_POST['Designation'];
    $qualification = $_POST['Qualification'];
    $email = $_POST['email'];
    $phone_no = $_POST['Phone_No']; 
    $username = $_POST['Username'];

    if (mysqli_query($conn, "UPDATE doctor SET Name = '$name', Designation = '$designation', Qualification = '$qualification', 
    email = '$email', Phone_No = '$phone_no', Username = '$username' WHERE Doctor_ID = '$_POST[id]'")) {

        echo "<script>alert('Doctor updated successfully.');location.href='doctor_profile.php';</script>";

    } else {

        echo "<script>alert('Unable to update Doctor.');location.href='doctor_profile.php';</script>";
    }
}

if (isset($_POST['delete'])) {

    if (mysqli_query($conn, "DELETE FROM doctor WHERE Doctor_ID = '$_POST[did]'")) {

        echo "<script>alert('Doctor deleted successfully.');location.href='doctor_profile.php';</script>";

    } else {

        echo "<script>alert('Unable to delete Doctor.');location.href='doctor_profile.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Doctor Profile</title>
    <?php
require_once 'include/meta.php';
require_once 'include/header.php';
    ?>
</head>
<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Doctor Profile</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Doctor Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPatientModalLabel">Add New Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="tel" class="form-control" id="Phone_No" name="Phone_No" placeholder="Phone Number" required pattern="[0-9]{10}" title="Please enter a 10-digit phone number" minlength="10" maxlength="10">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control" id="Designation" name="Designation" placeholder="Designation" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-book"></i></span>
                                        <input type="text" class="form-control" id="Qualification" name="Qualification" placeholder="Qualification" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                        <input type="text" class="form-control" id="Username" name="Username" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary" name="add">Save</button> 
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="container">
    <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="text-align: center;">Manage Doctor</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPatientModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Doctor
        </a>
    </div>
    <div class="table-responsive">
        <style>
            .custom-table th,
            .custom-table td {
                padding: 0.5rem;
                font-size: 14px;
            }
        </style>
        <div class="container">
                <div class="table-responsive">
                    <table class="table custom-table">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Doctor Name</th>
                    <th>Designation</th>
                    <th>Qualification</th>
                    <th>email</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resData = mysqli_query($conn, "SELECT * FROM doctor");
                if (mysqli_num_rows($resData) > 0) {
                    $i = 1; 
                    while ($row = mysqli_fetch_assoc($resData)) {
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Designation'] . "</td>";
                        echo "<td>" . $row['Qualification'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['Phone_No'] . "</td>";
                        echo "<td>";
                ?>
                        <form method="POST">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editPatientModal<?php echo $row['Doctor_ID']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <input type="hidden" name="did" value="<?php echo $row['Doctor_ID']; ?>" />
                            <button name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                <?php
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$resData = mysqli_query($conn, "SELECT * FROM doctor");
if (mysqli_num_rows($resData) > 0) {
    while ($row = mysqli_fetch_assoc($resData)) {
        ?>
        <div class="modal fade" id="editPatientModal<?php echo $row['Doctor_ID']; ?>" tabindex="-1" aria-labelledby="editPatientModalLabel<?php echo $row['Doctor_ID']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPatientModalLabel<?php echo $row['Doctor_ID']; ?>">Edit Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" value="<?php echo $row['Name']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                            <input type="text" class="form-control" id="Username" name="Username" placeholder="Username" value="<?php echo $row['Username']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php echo $row['email']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" class="form-control" id="Phone_No" name="Phone_No" placeholder="Phone Number" value="<?php echo $row['Phone_No']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                            <input type="text" class="form-control" id="Designation" name="Designation" placeholder="Designation" value="<?php echo $row['Designation']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                                            <input type="text" class="form-control" id="Qualification" name="Qualification" placeholder="Qualification" value="<?php echo $row['Qualification']; ?>">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="<?php echo $row['Doctor_ID']; ?>" />
                                <button type="submit" class="btn btn-outline-primary" name="update">Save</button>
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
        </div>
    </div>
</div> 

<?php
require_once 'include/footer.php';
?>
</body>
</html>

