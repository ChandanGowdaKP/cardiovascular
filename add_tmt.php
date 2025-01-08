<?php
session_start();

if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}
require_once 'config/connection.php';

if(!empty($_SESSION['userid'])){
    $docId = $_SESSION['userid'];
}
if(!empty($_SESSION['username'])){
    $username = $_SESSION['username'];
}
    
if (isset($_POST['submit'])) {

    $UHID = $_POST['UHID'];
    $Pretesthr = $_POST['Pretesthr'];
    $Pretestbp = $_POST['Pretestbp'];
    $Pretestmets = $_POST['Pretestmets'];
    $Supinehr = $_POST['Supinehr'];
    $Supinebp = $_POST['Supinebp'];
    $Supinemets = $_POST['Supinemets'];
    $Standinghr = $_POST['Standinghr'];
    $Standingbp = $_POST['Standingbp'];
    $Standingmets = $_POST['Standingmets'];
    $Hyperhr = $_POST['Hyperhr'];
    $Hyperbp = $_POST['Hyperbp'];
    $Hypermets = $_POST['Hypermets'];
    $Waithr = $_POST['Waithr'];
    $Waitbp = $_POST['Waitbp'];
    $Waitmets = $_POST['Waitmets'];
    $Ex1hr = $_POST['Ex1hr'];
    $Ex1bp = $_POST['Ex1bp'];
    $Ex1mets = $_POST['Ex1mets'];
    $Ex2hr = $_POST['Ex2hr'];
    $Ex2bp = $_POST['Ex2bp'];
    $Ex2mets = $_POST['Ex2mets'];
    $Ex3hr = $_POST['Ex3hr'];
    $Ex3bp = $_POST['Ex3bp'];
    $Ex3mets = $_POST['Ex3mets'];
    $Recoveryhr = $_POST['Recoveryhr'];
    $Recoverybp = $_POST['Recoverybp'];
    $Recoverymets = $_POST['Recoverymets'];
    $Recovery2hr = $_POST['Recovery2hr'];
    $Recovery2bp = $_POST['Recovery2bp'];
    $Recovery2mets = $_POST['Recovery2mets'];
    $Total_exercise_time = $_POST['Total_exercise_time'];
    $Max_workload = $_POST['Max_workload'];
    $Max_hr = $_POST['Max_hr'];
    $Distance_covered = $_POST['Distance_covered'];
    $Max_bp = $_POST['Max_bp'];
    $date = date('Y-m-d H:i:s');
    $insertQuery = "INSERT INTO tmt_transaction (UHID, Pretesthr, Pretestbp, Pretestmets, Supinehr, Supinebp, Supinemets, Standinghr, Standingbp, Standingmets, Hyperhr, Hyperbp, Hypermets, Waithr, Waitbp, Waitmets, Ex1hr, Ex1bp, Ex1mets, Ex2hr, Ex2bp, Ex2mets, Ex3hr, Ex3bp, Ex3mets, Recoveryhr, Recoverybp, Recoverymets, Recovery2hr, Recovery2bp, Recovery2mets, Total_exercise_time, Max_workload, Max_hr, Distance_covered, Max_bp, DocID) VALUES
     ('$UHID', '$Pretesthr', '$Pretestbp', '$Pretestmets', '$Supinehr', '$Supinebp', '$Supinemets', '$Standinghr', '$Standingbp', '$Standingmets', '$Hyperhr', '$Hyperbp', '$Hypermets', '$Waithr', '$Waitbp', '$Waitmets', '$Ex1hr', '$Ex1bp', '$Ex1mets', '$Ex2hr', '$Ex2bp', '$Ex2mets', '$Ex3hr', '$Ex3bp', '$Ex3mets', '$Recoveryhr', '$Recoverybp', '$Recoverymets', '$Recovery2hr', '$Recovery2bp', '$Recovery2mets', '$Total_exercise_time', '$Max_workload', '$Max_hr', '$Distance_covered', '$Max_bp', '$username')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "<script>alert('TMT Details added successfully');location.href='add_tmt.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='add_tmt.php'</script>";
    }
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
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">TMT</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">TMT</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mb-4">Treadmill Test</h1>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="UHID">Patient Name</label>
                        <select class="form-control" id="UHID" name="UHID" style="max-width: 400px;" required>
                            <option value="">Select Patient</option>
                            <?php 
                                $res1 = mysqli_query($conn,"SELECT UHID, username FROM patient_profile");
                                if(mysqli_num_rows($res1)>0){
                                    while($row = mysqli_fetch_assoc($res1)){
                                        echo "<option value='$row[UHID]'>$row[username]</option>";
                                         }
                                    }
                            ?>
                        </select>
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
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Pretesthr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Pretestbp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Pretestmets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Supine</td>
                                            <td>00:05</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Supinehr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Supinebp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Supinemets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Standing</td>
                                            <td>00:05</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Standinghr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Standingbp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Standingmets" required></td>
                                        </tr>
                                        <tr>
                                            <td>HyperVentilation</td>
                                            <td>00:05</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Hyperhr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Hyperbp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Hypermets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Wait for exercise</td>
                                            <td>00:05</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Waithr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Waitbp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Waitmets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Exercise stage 1</td>
                                            <td>03:00</td>
                                            <td>2.70</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex1hr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex1bp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex1mets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Exercise stage 2</td>
                                            <td>03:00</td>
                                            <td>4.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex2hr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex2bp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex2mets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Exercise stage 3</td>
                                            <td>03:00</td>
                                            <td>5.50</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex3hr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex3bp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Ex3mets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Recovery 1</td>
                                            <td>01:00</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recoveryhr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recoverybp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recoverymets" required></td>
                                        </tr>
                                        <tr>
                                            <td>Recovery 2</td>
                                            <td>03:00</td>
                                            <td>0.00</td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recovery2hr" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recovery2bp" required></td>
                                            <td><input type="text" class="form-control form-control-sm small-textbox" name="Recovery2mets" required></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="total-exercise-time">Total Exercise Time</label>
                                <input type="text" class="form-control form-control-sm small-textbox" id="total-exercise-time" name="Total_exercise_time" required>
                            </div>
                            <div class="col-md-3">
                                <label for="max-hr">Max HR</label>
                                <input type="text" class="form-control form-control-sm small-textbox" id="max-hr" name="Max_hr" required>
                            </div>
                            <div class="col-md-3">
                                <label for="max-bp">Max BP</label>
                                <input type="text" class="form-control form-control-sm small-textbox" id="max-bp" name="Max_bp" required>
                            </div>
                            <div class="col-md-3">
                                <label for="max-workload">Max Workload</label>
                                <input type="text" class="form-control form-control-sm small-textbox" id="max-workload" name="Max_workload" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="distance-covered">Distance Covered (km)</label>
                            <input type="text" class="form-control form-control-sm small-textbox" id="Distance_covered" name="Distance_covered" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <p class="text-center">Prepared by: <?php echo $username; ?></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
require_once 'include/footer.php';
?>
