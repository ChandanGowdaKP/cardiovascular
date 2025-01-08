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
INNER JOIN echo ON patient_profile.UHID = echo.UHID 
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

<title>View ECHO</title>
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
            <h1 style="text-align: center;">DEPARTMENT OF CARDIAC DIAGNOSIS</h1>

            <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .small-textbox {
        width: 100%;
        max-width: 200px;
    }
</style>
</head>
<body>
    <table>
        <tr>
            <th>Patient Name</th>
            <td>
                    <div style="display: flex; align-items: center;">
                            <?php echo $username; ?>
</div>
            </td>
        </tr>
        <tr>
            <th>Order no</th>
            <td><?php echo date('F j, Y', strtotime($row['Order_Date'])); ?></td>
        </tr>
        <tr>
            <th>Report date</th>
            <td><?php echo date('F j, Y', strtotime($row['Report_Date'])); ?></td>

        </tr>
        </tr>

        <tr>
            <th>Bill no/ Order no</th>
            <td><?php echo $row['BillNo_OrderNo']; ?></td>
        </tr>


        <tr>
            <th>IPNO</th>
            <td><?php echo $row['IPNO']; ?></td>
        </tr>

        <tr>
            <th>Bed No</th>
            <td><?php echo $row['Bed_No']; ?></td>
        </tr>
    </table>
            
            <h1 style="text-align: center;">ECHO COLOR DOPPLER</h1>
            <h4>Measurements:</h4>
            <table>
                <tr>
                    <th>Parameters</th>
                    <th>Value</th>
                    <th>Normal Value</th>
                </tr>
                <tr>
                    <td>Aortic root</td>
                    <td><?php echo $row['Aortic_Root']; ?></td>
                    <td>20-37 mm</td>
                </tr>
                <tr>
                    <td>Left Atrium</td>
                    <td><?php echo $row['Left_Atrium']; ?></td>
                    <td>19-35 mm</td>
                </tr>
                <tr>
                    <td>IVSd (Mild)</td>
                    <td><?php echo $row['IVSd']; ?></td>
                    <td>6-11 mm</td>
                </tr>
                <tr>
                    <td>LVPWd</td>
                    <td><?php echo $row['LVPWd']; ?></td>
                    <td>6-11 mm</td>
                </tr>
                <tr>
                    <td>LVIDd</td>
                    <td><?php echo $row['LVIDd']; ?></td>
                    <td>34-52 mm</td>
                </tr>
                <tr>
                    <td>LVIDs</td>
                    <td><?php echo $row['LVIDs']; ?></td>
                    <td>23-38 mm</td>
                </tr>
                <tr>
                    <td>LVEF</td>
                    <td><?php echo $row['LVEF']; ?></td>
                    <td>50-80%</td>
                </tr>
            </table>
            <div class="report-section">
                <h2>Descriptive Details</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $uhid = $row['UHID'];
                        $query = "SELECT Descriptive_Details, Result FROM tempdescdetails WHERE UHID = '$uhid'";
                        $result = mysqli_query($conn, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($desc_row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $desc_row['Descriptive_Details'] . "</td>";
                                echo "<td>" . $desc_row['Result'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No descriptive details found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="impression">
                <h2>Impression</h2>
                <p><?php echo $row['Impression']; ?></p>
            </div>
            <div class="text-center mb-4">
    <a href="echo-pdf.php" class="btn btn-danger">
        <i class="fas fa-print"></i> Print
    </a>
</div>

        </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-CZbIe4Mp3DvCkc7Yk90A3rD/SHwVuviQIHUiUuWf4dZl5PujRQUGJlgsJq+riMbsTV6NzEgi+Ka2HLhWgdXUew==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php
    require_once 'include/footer.php';
    ?>

</body>
</html>
