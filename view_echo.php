<?php
session_start();

if(!isset($_SESSION['isLogin'])){

    header("Location: login.php");
    exit();
}
    require_once 'config/connection.php';
  
    if (empty($_GET['f_text'])) {

        $f_text = "";
    } else {
    
        $f_text = $_GET['f_text'];
    }
    
    
    $sql = "SELECT * from echo";
    if (isset($_GET['f_search'])) {
        if (!empty($_GET['f_text'])) {
            $f_text = $_GET['f_text'];
            $keywords = "%" . $f_text . "%";
            $sql = "SELECT e.*, t.*, t.Descriptive_Details
        FROM echo e
        JOIN tempdescdetails t ON e.UHID = t.UHID
        WHERE e.UHID LIKE '$keywords'";
;
        
            $res = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
            }
        }
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
            <h1>DEPARTMENT OF CARDIAC DIAGNOSIS</h1>
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
            <th>UHID</th>
            <td>
                <form>
                    <div style="display: flex; align-items: center;">
                        <input type="text" class="form-control form-control-sm small-textbox" type="text" name="f_text" placeholder="Search by UHID" value="<?php echo $f_text; ?>" style="margin-right: 5px;">
                        <button class="btn btn-outline-primary btn-sm" name="f_search" style="margin-right: 5px;">Search</button>
                        <a class="btn btn-outline-danger btn-sm" href="view_echo.php">Clear</a>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <th>Order no</th>
            <td><?php echo isset($row['Order_Date']) ? date('d-m-Y', strtotime($row['Order_Date'])) : ''; ?></td>
        </tr>
        <tr>
            <th>Report date</th>
            <td><?php echo isset($row['Report_Date']) ? date('d-m-Y', strtotime($row['Report_Date'])) : ''; ?></td>
        </tr>
        </tr>

        <tr>
            <th>Bill no/ Order no</th>
            <td><?php echo isset($row['BillNo_OrderNo']) ? $row['BillNo_OrderNo'] : ''; ?></td>
        </tr>


        <tr>
            <th>IPNO</th>
            <td><?php echo isset($row['IPNO']) ? $row['IPNO'] : ''; ?></td>
        </tr>

        <tr>
            <th>Bed No</th>
            <td><?php echo isset($row['Bed_No']) ? $row['Bed_No'] : ''; ?></td>
        </tr>
    </table>
            
            <h2>ECHO COLOR DOPPLER</h2>
            <h4>Measurements:</h4>
            <table>
                <tr>
                    <th>Parameters</th>
                    <th>Value</th>
                    <th>Normal Value</th>
                </tr>
                <tr>
                    <td>Aortic root</td>
                    <td><?php echo isset($row['Aortic_Root']) ? $row['Aortic_Root'] : ''; ?></td>
                    <td>20-37 mm</td>
                </tr>
                <tr>
                    <td>Left Atrium</td>
                    <td><?php echo isset($row['Left_Atrium']) ? $row['Left_Atrium'] : ''; ?></td>
                    <td>19-35 mm</td>
                </tr>
                <tr>
                    <td>IVSd (Mild)</td>
                    <td><?php echo isset($row['IVSd']) ? $row['IVSd'] : ''; ?></td>
                    <td>6-11 mm</td>
                </tr>
                <tr>
                    <td>LVPWd</td>
                    <td><?php echo isset($row['LVPWd']) ? $row['LVPWd'] : ''; ?></td>
                    <td>6-11 mm</td>
                </tr>
                <tr>
                    <td>LVIDd</td>
                    <td><?php echo isset($row['LVIDd']) ? $row['LVIDd'] : ''; ?></td>
                    <td>34-52 mm</td>
                </tr>
                <tr>
                    <td>LVIDs</td>
                    <td><?php echo isset($row['LVIDs']) ? $row['LVIDs'] : ''; ?></td>
                    <td>23-38 mm</td>
                </tr>
                <tr>
                    <td>LVEF</td>
                    <td><?php echo isset($row['LVEF']) ? $row['LVEF'] : ''; ?></td>
                    <td>50-80%</td>
                </tr>
            </table>
            <div class="Descriptive details">
    <h2>Descriptive details</h2>
    <table>
        <tr>
            <th>Description</th>
            <th>Result</th>
        </tr>
            <td><?php echo isset($row['Descriptive_Details']) ? $row['Descriptive_Details'] : ''; ?></td>
            <td><?php echo isset($row['Result']) ? $row['Result'] : ''; ?></td>
        </tr>
    </table>
</div>


            
            <div class="impression">
                <h2>Impression</h2>
                <p><?php echo isset($row['Impression']) ? $row['Impression'] : ''; ?></p>
            </div>
            <div class="text-center mb-4">
    <a href="view_echo-pdf.php" class="btn btn-danger">
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
