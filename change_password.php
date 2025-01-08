<?php
session_start();

if(!isset($_SESSION['isLogin'])){

    header("Location: login.php");
    exit();
}
require_once 'config/connection.php';



if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    $username = $_SESSION['username'];


    if ($new_password !== $confirm_new_password) {
        echo "<script>alert('New password and confirm new password do not match');</script>";
        exit();
    }


    $result = mysqli_query($conn, "SELECT * FROM user_creation WHERE username = '$username' AND password = '$current_password'");
    if(mysqli_num_rows($result) == 1){
        $update_query = "UPDATE user_creation SET password = '$new_password' WHERE username = '$username'";
        $update_result = mysqli_query($conn, $update_query);
        if($update_result){
            echo "<script>alert('Password changed successfully');</script>";
        } else {
            echo "<script>alert('Failed to change password');</script>";
        }
    } else {
        echo "<script>alert('Incorrect current password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Change Password</title>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Change Password</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Change Password</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-4">Change Your Password</h5>
                        <form action="" method = "POST">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_new_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once 'include/footer.php';
?>
</body>

</html>
