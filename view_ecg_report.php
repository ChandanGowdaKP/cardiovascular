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

$sql = "SELECT * FROM patient_profile 
INNER JOIN ecg ON patient_profile.UHID = ecg.UHID 
WHERE patient_profile.username = '$username'"; 

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Patient ECG Report not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ECG</title>
    <?php
        require_once 'include/meta.php';
        require_once 'include/header.php';
    ?>
    <style>
        th {
            font-weight: bold;
            color: #333;
        }
        .small-textbox {
            width: 400px;
        }
    </style>
</head>
<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">ECG</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">ECG</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mb-4">Electro Cardio Gram</h1>
            </div>
            <div class="card-body">

                        <div style="display: flex; align-items: center;">
                            <label>Patient Name : <?php echo $username; ?></label>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless" style="margin-left: auto; margin-right: auto;">
                        <thead>
                            <tr>
                                <th style="width: 300px;">Measurement Result</th>
                                <th>Your Value</th>
                                <th>Normal Values</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>QRS</td>
                                <td><?php echo $row['QRS']; ?></td>
                                <td>&lt; 90 ms</td>
                            </tr>
                            <tr>
                                <td>QT/QTcB</td>
                                <td><?php echo $row['QT']; ?></td>
                                <td>&lt; 400 ms</td>
                            </tr>
                            <tr>
                                <td>PR</td>
                                <td><?php echo $row['PR']; ?></td>
                                <td>138 ms</td>
                            </tr>
                            <tr>
                                <td>P</td>
                                <td><?php echo $row['P']; ?></td>
                                <td>&lt; 100 ms</td>
                            </tr>
                            <tr>
                                <td>RR</td>
                                <td><?php echo $row['RR_PP']; ?></td>
                                <td>&lt; 750 ms</td>
                            </tr>
                            <tr>
                                <td>P/QRS/T</td>
                                <td><?php echo $row['P_QRS_T']; ?></td>
                                <td>&lt; 100 degree</td>
                            </tr>
                            <tr>
                                <td>QTD/QTcBD</td>
                                <td><?php echo $row['QTD_QTcBD']; ?></td>
                                <td>&lt; 80 ms</td>
                            </tr>
                            <tr>
                                <td>Sokolow</td>
                                <td><?php echo $row['Sokolow']; ?></td>
                                <td>1.3 - 3.5 mV</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td><?php echo $row['Type']; ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center mt-4 mb-4">
            <?php
            if(isset($row['File']) && !empty($row['File'])) {
                $imagePath = 'images/' . $row['File']; 
                echo "<img src='$imagePath' alt='Image' class='img-fluid' style='max-width: 800px; max-height: 400px;'>";
            } else {
                echo "No image available";
            }
            ?>
        </div>

        <div class="text-center mb-4">
    <a href="ecg-pdf.php" class="btn btn-danger">
        <i class="fas fa-print"></i> Print
    </a>
</div>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-CZbIe4Mp3DvCkc7Yk90A3rD/SHwVuviQIHUiUuWf4dZl5PujRQUGJlgsJq+riMbsTV6NzEgi+Ka2HLhWgdXUew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
require_once 'include/footer.php';
?>
