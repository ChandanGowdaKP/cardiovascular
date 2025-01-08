<?php
session_start();

if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}

require_once 'config/connection.php';

if (isset($_POST['add'])) {
    $name = $_POST['username'];
    $gender = $_POST['Gender'];
    $dob = $_POST['DOB'];
    $age = $_POST['Age'];
    $address = $_POST['Address'];
    $phone = $_POST['Phone'];
    $injuries = $_POST['Injuries'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (mysqli_query($conn, "INSERT INTO patient_profile (username, Gender, DOB, Age, Address, Phone, Injuries) 
                        VALUES ('$name', '$gender', '$dob', '$age', '$address', '$phone', '$injuries')")) {
        if (mysqli_query($conn, "INSERT INTO user_creation (username, password, email, usertype) 
                            VALUES ('$name', '$password', '$email', 'Patients')")) {
            echo "<script>alert('Patient added successfully.');location.href='patient_profile.php';</script>";
        } else {
            echo "<script>alert('Unable to add Patient to another table.');location.href='patient_profile.php';</script>";
        }
    }
}

if (isset($_POST['update'])) {
    $name = $_POST['username'];
    $gender = $_POST['Gender'];
    $age = $_POST['Age'];
    $address = $_POST['Address'];
    $phone = $_POST['Phone'];
    $injuries = $_POST['Injuries'];

    if (mysqli_query($conn, "UPDATE patient_profile SET username = '$name', Gender = '$gender', Age = '$age',Address = '$address',Phone = '$phone',
            Injuries = '$injuries' WHERE UHID = '$_POST[id]'")) {
         echo "<script>alert('Patient updated successfully.');location.href='patient_profile.php';</script>";
     } else {
        echo "<script>alert('Unable to update Patient.');location.href='patient_profile.php';</script>";
    }
}

if (isset($_POST['delete'])) {
    if (mysqli_query($conn, "DELETE FROM patient_profile WHERE UHID = '$_POST[did]'")) {
        echo "<script>alert('Patient deleted successfully.');location.href='patient_profile.php';</script>";
    } else {
        echo "<script>alert('Unable to delete patient.');location.href='patient_profile.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Profile</title>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Patient Profile</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Patient Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <!-- <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="UHID" name="UHID" placeholder="Patient ID" required>
                                </div> -->
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="Name" name="username" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control" id="DOB" name="DOB" placeholder="Date of Birth" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="number" class="form-control" id="Age" name="Age" placeholder="Age" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
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
                                    <input type="tel" class="form-control" id="Phone" name="Phone" placeholder="Phone Number" required pattern="[0-9]{10}" title="Please enter a 10-digit phone number" minlength="10" maxlength="10">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-house"></i></span>
                                    <textarea class="form-control" id="Address" name="Address" placeholder="Address" required></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <select class="form-select" id="Gender" name="Gender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male">&#9794; Male</option>
                                        <option value="female">&#9792; Female</option>
                                        <option value="other">&#9898; Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="injuries">Are there injuries?</label>
                                <div class="input-group">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Injuries" id="Injuries" value="Yes" required>
                                                <label class="form-check-label" for="injuries_yes">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="Injuries" id="Injuries" value="No" required>
                                                <label class="form-check-label" for="injuries_no">No</label>
                                            </div>
                                        </div>
                                    </div>
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
        <h1 class="h3 mb-0 text-gray-800" style="text-align: center;">Manage Patient</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPatientModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add Patient
        </a>
    </div>
    <div class="table-responsive">
        <style>
            .custom-table th,
            .custom-table td {
                padding: 0.5rem; /* Adjust the padding */
                font-size: 14px; /* Adjust the font size */
            }
        </style>
        <div class="container">
                <div class="table-responsive">
                    <table class="table custom-table">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Date Of Birth</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Injuries</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resData = mysqli_query($conn, "SELECT * FROM patient_profile ORDER BY UHID DESC");
                if (mysqli_num_rows($resData) > 0) {
                    $i = 1; 
                    while ($row = mysqli_fetch_assoc($resData)) {
                        // Display patient details in table rows
                        echo "<tr>";
                        echo "<td>" . $i . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['Gender'] . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($row['DOB'])) . "</td>";
                        echo "<td>" . $row['Age'] . "</td>";
                        echo "<td>" . $row['Address'] . "</td>";
                        echo "<td>" . $row['Phone'] . "</td>";
                        echo "<td>" . $row['Injuries'] . "</td>";
                        echo "<td>";
                ?>
                        <form method="POST">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editPatientModal<?php echo $row['UHID']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <input type="hidden" name="did" value="<?php echo $row['UHID']; ?>" />
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





<!-- Modals for Editing Patients -->
<?php
$resData = mysqli_query($conn, "SELECT * FROM patient_profile");
if (mysqli_num_rows($resData) > 0) {
    while ($row = mysqli_fetch_assoc($resData)) {
        ?>
        <div class="modal fade" id="editPatientModal<?php echo $row['UHID']; ?>" tabindex="-1" aria-labelledby="editPatientModalLabel<?php echo $row['UHID']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPatientModalLabel<?php echo $row['UHID']; ?>">Edit Patient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="hidden" name="id" value="<?php echo $row['UHID']; ?>">
                                            <input type="text" class="form-control" id="Name" name="username" placeholder="Name" value="<?php echo $row['username']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                            <input type="number" class="form-control" id="Age" name="Age" placeholder="Age" value="<?php echo $row['Age']; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label" for="injuries">Are there injuries?</label>
                                        <div class="input-group">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="Injuries" id="injuries_yes" value="Yes" <?php if($row['Injuries'] == 'Yes') echo 'checked'; ?>>
                                                        <label class="form-check-label" for="injuries_yes">Yes</label>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="Injuries" id="injuries_no" value="No" <?php if($row['Injuries'] == 'No') echo 'checked'; ?>>
                                                        <label class="form-check-label" for="injuries_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" class="form-control" id="Phone" name="Phone" placeholder="Phone Number" value="<?php echo $row['Phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-house"></i></span>
                                            <textarea class="form-control" id="Address" name="Address" placeholder="Address"><?php echo $row['Address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <select class="form-select" id="Gender" name="Gender">
                                                <option value="" disabled>Select Gender</option>
                                                <option value="male" <?php if($row['Gender'] == 'male') echo 'selected'; ?>>&#9794; Male</option>
                                                <option value="female" <?php if($row['Gender'] == 'female') echo 'selected'; ?>>&#9792; Female</option>
                                                <option value="other" <?php if($row['Gender'] == 'other') echo 'selected'; ?>>&#9898; Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="modal-footer">
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
