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
INNER JOIN tmt_transaction ON patient_profile.UHID = tmt_transaction.UHID 
WHERE patient_profile.username = '$username'"; 

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Patient TMT Report not found.";
    exit;
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>TMT</title>
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
            width: 200px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
            <h1 class="text-center mb-4">TMT TRANSACTION Report</h1>
            </div>
            <div class="card-body">

                    <div style="display: flex; align-items: center;">
                            <label>Patient Name : <?php echo $username; ?></label>
                        </div>
      
                    <div class="table-responsive">
                    <table class="table table-borderless" style="margin-left: auto; margin-right: auto;">
        <thead>
            <tr>
                <th>Stage</th>
                <th>Stage Time</th>
                <th>Speed (Kmph)</th>
                <th>HR</th>
                <th>BP</th>
                <th>METS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pre-test</td>
                <td>00:12</td>
                <td>0.00</td>
                <td><?php echo $row['Pretesthr']; ?></td>
                <td><?php echo $row['Pretestbp']; ?></td>
                <td><?php echo $row['Pretestmets']; ?></td>
            </tr>
            <tr>
                <td>Supine</td>
                <td>00:05</td>
                <td>0.00</td>
                <td><?php echo $row['Supinehr']; ?></td>
                <td><?php echo $row['Supinebp']; ?></td>
                <td><?php echo $row['Supinemets']; ?></td>
            </tr>
            <tr>
                <td>Standing</td>
                <td>00:05</td>
                <td>0.00</td>
                <td><?php echo $row['Standinghr']; ?></td>
                <td><?php echo $row['Standingbp']; ?></td>
                <td><?php echo $row['Standingmets']; ?></td>
            </tr>
            <tr>
                <td>HyperVentilation</td>
                <td>00:05</td>
                <td>0.00</td>
                <td><?php echo $row['Hyperhr']; ?></td>
                <td><?php echo $row['Hyperbp']; ?></td>
                <td><?php echo $row['Hypermets']; ?></td>
            </tr>
            <tr>
                <td>Wait for exercise</td>
                <td>00:05</td>
                <td>0.00</td>
                <td><?php echo $row['Waithr']; ?></td>
                <td><?php echo $row['Waitbp']; ?></td>
                <td><?php echo $row['Waitmets']; ?></td>
            </tr>
            <tr>
                <td>Exercise stage 1</td>
                <td>03:00</td>
                <td>2.70</td>
                <td><?php echo $row['Ex1hr']; ?></td>
                <td><?php echo $row['Ex1bp']; ?></td>
                <td><?php echo $row['Ex1mets']; ?></td>
            </tr>
            <tr>
                <td>Exercise stage 2</td>
                <td>03:00</td>
                <td>4.00</td>
                <td><?php echo $row['Ex2hr']; ?></td>
                <td><?php echo $row['Ex2bp']; ?></td>
                <td><?php echo $row['Ex2mets']; ?></td>
            </tr>
            <tr>
                <td>Exercise stage 3</td>
                <td>03:00</td>
                <td>5.50</td>
                <td><?php echo $row['Ex3hr']; ?></td>
                <td><?php echo $row['Ex3bp']; ?></td>
                <td><?php echo $row['Ex3mets']; ?></td>
            </tr>
            <tr>
                <td>Recovery 1</td>
                <td>01:00</td>
                <td>0.00</td>
                <td><?php echo $row['Recoveryhr']; ?></td>
                <td><?php echo $row['Recoverybp']; ?></td>
                <td><?php echo $row['Recoverymets']; ?></td>
            </tr>
            <tr>
                <td>Recovery 2</td>
                <td>03:00</td>
                <td>0.00</td>
                <td><?php echo $row['Recovery2hr']; ?></td>
                <td><?php echo $row['Recovery2bp']; ?></td>
                <td><?php echo $row['Recovery2mets']; ?></td>
            </tr>
        </tbody>
    </table> 
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="total-exercise-time">Total Exercise Time</label>
                            <input type="text" class="form-control form-control-sm small-textbox" value="<?php echo $row['Total_exercise_time']; ?>" id="total-exercise-time" name="Total_exercise_time">
                        </div>
                        <div class="col-md-3">
                            <label for="max-hr">Max HR</label>
                            <input type="text" class="form-control form-control-sm small-textbox" value="<?php echo $row['Max_hr']; ?>" id="max-hr" name="Max_hr">
                        </div>
                        <div class="col-md-3">
                            <label for="max-bp">Max BP</label>
                            <input type="text" class="form-control form-control-sm small-textbox" value="<?php echo $row['Max_bp']; ?>" id="max-bp" name="Max_bp">
                        </div>
                        <div class="col-md-3">
                            <label for="max-workload">Max Workload</label>
                            <input type="text" class="form-control form-control-sm small-textbox" value="<?php echo $row['Max_workload']; ?>" id="max-workload" name="Max_workload">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="distance-covered">Distance Covered</label>
                            <input type="text" class="form-control form-control-sm small-textbox" value="<?php echo $row['Distance_covered']; ?>" id="distance-covered" name="Distance_covered">
                        </div>
                    </div>
                    <div class="text-center mb-4">
    <a href="tmt-pdf.php" class="btn btn-danger">
        <i class="fas fa-print"></i> Print
    </a>
</div>

                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-CZbIe4Mp3DvCkc7Yk90A3rD/SHwVuviQIHUiUuWf4dZl5PujRQUGJlgsJq+riMbsTV6NzEgi+Ka2HLhWgdXUew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            </div>
        </div>
    </div>
    

    <?php
    require_once 'include/footer.php';

    ?>
</body>
</html>
