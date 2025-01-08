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
    $QRS = $_POST['QRS'];
    $QT = $_POST['QT'];
    $PR = $_POST['PR'];
    $P = $_POST['P'];
    $RR_PP = $_POST['RR_PP'];
    $P_QRS_T = $_POST['P_QRS_T'];
    $QTD_QTcBD = $_POST['QTD_QTcBD'];
    $Sokolow = $_POST['Sokolow'];
    $Type = $_POST['Type'];


    $date = date('Y-m-d H:i:s');
    $imagePath = time() . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES['file']['tmp_name'], "images/" . $imagePath)) {

        $insertQuery = "INSERT INTO ecg (UHID, QRS, QT, PR, P, RR_PP, P_QRS_T, QTD_QTcBD, Sokolow, Type, File, DocID) VALUES
         ('$UHID', '$QRS', '$QT', '$PR', '$P', '$RR_PP', '$P_QRS_T', '$QTD_QTcBD', '$Sokolow', '$Type',  '$imagePath', '$username')";

        if (mysqli_query($conn, $insertQuery)) {
            echo "<script>alert('ECG Details added successfully');location.href='add_ecg.php'</script>";
        } else {
            echo "<script>alert('Unable to process your request!');location.href='add_ecg.php'</script>";
        }
    } else {
        echo "<script>alert('Unable to upload image on server.');</script>";
    }   
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
                                    <th style="width: 300px;">Measurement Result</th>
                                    <th>Your Value</th>
                                    <th>Normal Values</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr>
                                    <td>QRS</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="QRS" name="QRS" required></td>
                                    <td>&lt; 90 ms</td>
                                </tr>
                                <tr>
                                    <td>QT/QTcB</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="QT" name="QT" required></td>
                                    <td>&lt; 400 ms</td>
                                </tr>
                                <tr>
                                    <td>PR</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="PR" name="PR" required></td>
                                    <td>138 ms</td>
                                </tr>
                                <tr>
                                    <td>P</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="P" name="P" required></td>
                                    <td>&lt; 100 ms</td>
                                </tr>
                                <tr>
                                    <td>RR</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="RR_PP" name="RR_PP" required></td>
                                    <td>&lt; 750 ms</td>
                                </tr>
                                <tr>
                                    <td>P/QRS/T</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="P_QRS_T" name="P_QRS_T" required></td>
                                    <td>&lt; 100 degree</td>
                                </tr>
                                <tr>
                                    <td>QTD/QTcBD</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="QTD_QTcBD" name="QTD_QTcBD" required></td>
                                    <td>&lt; 80 ms</td>
                                </tr>
                                <tr>
                                    <td>Sokolow</td>
                                    <td><input type="text" class="form-control form-control-sm small-textbox" id="Sokolow" name="Sokolow" required></td>
                                    <td>1.3 - 3.5 mV</td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <select class="form-control form-control" id="Type" name="Type" style="max-width: 400px;" required>
                                                <option value="">Select Type</option>    
                                                <option value="Normal">Normal</option>
                                                <option value="Abnormal">Abnormal</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Image File</td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control custom-file-input" id="file" name="file" style="max-width: 400px;" required>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
