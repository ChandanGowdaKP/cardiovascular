<?php
session_start();

if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
}

require_once 'config/connection.php';

if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];

    if (mysqli_query($conn, "INSERT INTO user_creation (username, email, usertype, password) 
                             VALUES ('$username', '$email', '$usertype', '$password')")) {
        echo "<script>alert('User added successfully .');location.href='user_creation.php';</script>";
    } else {
        echo "<script>alert('Unable to add User.');</script>";
    }
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];

    if (mysqli_query($conn, "UPDATE user_creation SET username = '$username', email = '$email',
        usertype = '$usertype'WHERE user_id = '$_POST[id]'")) {

        echo "<script>alert('User updated successfully.');</script>";
    } else {
        echo "<script>alert('Unable to update User.');</script>";
    }
}

if (isset($_POST['delete'])) {
    if (mysqli_query($conn, "DELETE FROM user_creation WHERE user_id = '$_POST[did]'")) {
        echo "<script>alert('User deleted successfully.');location.href='user_creation.php';</script>";
    } else {
        echo "<script>alert('Unable to delete User.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration</title>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Registration</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Registration</li>
                </ol>
            </nav>
        </div>
    </div>

<div class="modal fade" id="addPatientsModal" tabindex="-1" aria-labelledby="addPatientsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientsModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
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
                    <div class="mb-3">
                        <div class="input-group">
                            <label for="usertype" class="input-group-text">User Type</label>
                            <select class="form-select" id="usertype" name="usertype" required>
                                <option value="">Select User Type</option>
                                <option value="admin">Admin <i class="bi bi-shield-lock"></i></option>
                                <option value="Doctors">Doctors <i class="bi bi-person-badge"></i></option>
                                <option value="Patients">Patients <i class="bi bi-person"></i></option>
                            </select>
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
            <h1 class="h3 mb-0 text-gray-800">Manage User</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-sm-end" data-bs-toggle="modal" data-bs-target="#addPatientsModal"> <!-- Added float-sm-end class -->
                <i class="fas fa-plus fa-sm text-white-50"></i> Add User
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
                                <th>User Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resData = mysqli_query($conn, "SELECT * FROM user_creation ORDER BY user_id DESC");
                            if (mysqli_num_rows($resData) > 0) {
                                $i = 1; 
                                while ($row = mysqli_fetch_assoc($resData)) {
                                    // Display Patients details in table rows
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['usertype'] . "</td>";
                                    echo "<td>";
                            ?>
                                    <form method="POST">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#editPatientsModal<?php echo $row['user_id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                        <input type="hidden" name="did" value="<?php echo $row['user_id']; ?>" />
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
            $resData = mysqli_query($conn, "SELECT * FROM user_creation");
            if (mysqli_num_rows($resData) > 0) {
                while ($row = mysqli_fetch_assoc($resData)) {
                    ?>
                    <div class="modal fade" id="editPatientsModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="editPatientsModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPatientsModalLabel<?php echo $row['user_id']; ?>">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Name" value="<?php echo $row['username']; ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $row['email']; ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <label for="user_type" class="input-group-text">User Type</label>
                                                    <select class="form-select" id="usertype" name="usertype" required>
                                                        <option value="">Select User Type</option>
                                                        <option value="Admin" <?php if ($row['usertype'] == 'Admin') echo 'selected'; ?>>Admin <i class="bi bi-shield-lock"></i></option>
                                                        <option value="Doctors" <?php if ($row['usertype'] == 'Doctors') echo 'selected'; ?>>Doctors <i class="bi bi-person-badge"></i></option>
                                                        <option value="Patients" <?php if ($row['usertype'] == 'Patients') echo 'selected'; ?>>Patients <i class="bi bi-person"></i></option>
                                                    </select>
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
