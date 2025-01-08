<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}

require_once 'config/connection.php';

if (!empty($_SESSION['userid'])) {
    $docId = $_SESSION['userid'];
}
if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if (isset($_POST['submit'])) {

    $UHID = mysqli_real_escape_string($conn, $_POST['UHID']);
    $Report_Date = mysqli_real_escape_string($conn, $_POST['Report_Date']);
    $BillNo_OrderNo = mysqli_real_escape_string($conn, $_POST['BillNo_OrderNo']);
    $IPNO = mysqli_real_escape_string($conn, $_POST['IPNO']);
    $Bed_No = mysqli_real_escape_string($conn, $_POST['Bed_No']);
    $Aortic_Root = mysqli_real_escape_string($conn, $_POST['Aortic_Root']);
    $Left_Atrium = mysqli_real_escape_string($conn, $_POST['Left_Atrium']);
    $IVSd = mysqli_real_escape_string($conn, $_POST['IVSd']);
    $LVPWd = mysqli_real_escape_string($conn, $_POST['LVPWd']);
    $LVIDd = mysqli_real_escape_string($conn, $_POST['LVIDd']);
    $LVIDs = mysqli_real_escape_string($conn, $_POST['LVIDs']);
    $LVEF = mysqli_real_escape_string($conn, $_POST['LVEF']);
    $Descriptive_Details = mysqli_real_escape_string($conn, $_POST['Descriptive_Details']);
    $Result = mysqli_real_escape_string($conn, $_POST['Result']);
    $Impression = mysqli_real_escape_string($conn, $_POST['Impression']);

    $date = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO ECHO (UHID, Order_Date, Report_Date, BillNo_OrderNo, IPNO, Bed_No, Aortic_Root, Left_Atrium, IVSd, LVPWd, LVIDd, LVIDs, LVEF, Descriptive_Details, Impression, DocID) VALUES
         ('$UHID', '$date', '$Report_Date', '$BillNo_OrderNo', '$IPNO', '$Bed_No', '$Aortic_Root', '$Left_Atrium', '$IVSd', '$LVPWd', '$LVIDd', '$LVIDs', '$LVEF', '$Descriptive_Details', '$Impression','$username')";

    $insertQuery1 = "INSERT INTO tempdescdetails (UHID, Descriptive_Details, Result) VALUES
         ('$UHID', '$Descriptive_Details', '$Result')";

    if (mysqli_query($conn, $insertQuery) && mysqli_query($conn, $insertQuery1)) {
        echo "<script>alert('ECHO Details added successfully');location.href='add_echo.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='add_echo.php'</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ECHO</title>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">ECHO</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">ECHO</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mb-4">ECHO COLOR DOPPLER</h1>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-borderless" style="margin-left: auto; margin-right: auto;">
                            <tr>
                                <th>UHID</th>
                                <td>
                                    <select class="form-control" id="UHID" name="UHID" style="max-width: 400px;">
                                        <option value="">Select Patient</option>
                                        <?php
                                        $res1 = mysqli_query($conn, "SELECT UHID, username FROM patient_profile");
                                        if (mysqli_num_rows($res1) > 0) {
                                            while ($row = mysqli_fetch_assoc($res1)) {
                                                echo "<option value='{$row['UHID']}'>{$row['username']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
    <th>Order Date</th>
    <td><input type="date" class="form-control form-control-sm small-textbox" id="Order_Date" name="Order_Date" value="<?php echo date('Y-m-d'); ?>" required readonly></td>
</tr>

                            <tr>
                                <th>Report date</th>
                                <td><input type="date" class="form-control form-control-sm small-textbox" id="Report_Date" name="Report_Date" required></td>
                            </tr>
                            <tr>
                                <th>Bill no/Order no</th>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="BillNo_OrderNo" name="BillNo_OrderNo" required></td>
                            </tr>
                            <tr>
                                <th>IPNO</th>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="IPNO" name="IPNO" required></td>
                            </tr>
                            <tr>
                                <th>Bed No</th>
                                <td><input type="text" class="form-control form-control-sm small-textbox" id="Bed_No" name="Bed_No" required></td>
                            </tr>
                            <!-- Other form fields -->
                        </table>
                    </div>

                    <div class="report-section">
                        <h2></h2>
                        <table class="table table-borderless" style="margin-left: auto; margin-right: auto;">
                            <tr>
                            <tr>
                                <th> <div class="report-section">
                                    <h4>Parameter</h4></th>
                                <th> <div class="report-section">
                                    <h4>Value</h4></th>
                                <th><div class="report-section">
                                    <h4>Normal Value</h4></th>
                            </tr>
                            </tr>
                            <tr>
                                <td>Aortic Root</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="Aortic_Root" name="Aortic_Root" required></td>
                                <td>20-37 mm</td>
                            </tr>
                            <tr>
                                <td>Left Atrium</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="Left_Atrium" name="Left_Atrium" required></td>
                                <td>19-35 mm</td>
                            </tr>
                            <tr>
                                <td>IVSd</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="IVSd" name="IVSd" required></td>
                                <td>6-11 mm</td>
                            </tr>
                            <tr>
                                <td>LVPWd</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="LVPWd" name="LVPWd" required></td>
                                <td>6-11 mm</td>
                            </tr>
                            <tr>
                                <td>LVIDd</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="LVIDd" name="LVIDd" required></td>
                                <td>34-52 mm</td>
                            </tr>
                            <tr>
                                <td>LVIDs</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="LVIDs" name="LVIDs" required></td>
                                <td>23-38 mm</td>
                            </tr>
                            <tr>
                                <td>LVEF</td>
                                <td><input type="number" class="form-control form-control-sm small-textbox" id="LVEF" name="LVEF" required></td>
                                <td>50-80%</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Report section with dropdowns -->
                    <div class="report-section">
                        <h2>Descriptive Details</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control form-control-sm" id="DescriptionDropdown" name="Descriptive_Details" required>
                                    <option value="">Select Description</option>
                                    <?php
                                    $query = "SELECT DISTINCT Descriptive_Details FROM tempdescdetails";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['Descriptive_Details']}'>{$row['Descriptive_Details']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control form-control-sm" id="ResultDropdown" name="Result" required>
                                    <option value="">Select Result</option>
                                    <?php
                                    $query = "SELECT DISTINCT Result FROM tempdescdetails";
                                    $result = mysqli_query($conn, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['Result']}'>{$row['Result']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Impression section -->
                    <div class="report-section">
                        <h2>Impression</h2>
                        <textarea class="form-control form-control-sm small-textbox" id="Impression" name="Impression" rows="4"></textarea>
                    </div>

                    <!-- Submit button -->
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>

                    <!-- Prepared by -->
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <p class="text-center">Prepared by: <?php echo $username; ?></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require_once 'include/footer.php';
?>
