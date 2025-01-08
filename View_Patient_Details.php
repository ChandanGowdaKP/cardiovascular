<?php
session_start();
require_once 'config/connection.php';

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit; 
}
if(!empty($_SESSION['username'])){
    $username = $_SESSION['username'];
}

$sql = "SELECT * FROM patient_profile WHERE username = '$username'"; 

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Patient not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Patient Details</title>
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
        <div class="container py-5">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mb-4">Patient Details</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                    <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><div class="report-section"><h6>Patient Id</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Name</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Gender</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Date Of Birth</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Age</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Address</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Phone</h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6>Injuries</h6></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo ($row['UHID']); ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['username']; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['Gender']; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo date('d-m-Y', strtotime($row['DOB'])); ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['Age']; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['Address']; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['Phone']; ?></h6></td>
                                </tr>
                                <tr>
                                    <td><div class="report-section"><h6><?php echo $row['Injuries']; ?></h6></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'include/footer.php';
?>
