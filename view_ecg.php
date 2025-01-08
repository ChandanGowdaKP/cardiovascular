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
            $sql = "SELECT * FROM ecg WHERE UHID LIKE '$keywords'";
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
                    <form>
                        <div style="display: flex; align-items: center;">
                        <label>Patient ID</label>
                        <input type="text" class="form-control form-control-sm small-textbox" name="f_text" placeholder="Search by UHID" value="<?php echo $f_text; ?>" style="margin-right: 5px; width: 200px;">
                            <button class="btn btn-outline-primary btn-sm" name="f_search" style="margin-right: 5px;">Search</button>
                            <a class="btn btn-outline-danger btn-sm" href="view_ecg.php">Clear</a>
                        </div>
                    </form>
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
                                <td><?php echo isset($row['QRS']) ? $row['QRS'] : ''; ?></td>
                                <td>&lt; 90 ms</td>
                            </tr>
                            <tr>
                                <td>QT/QTcB</td>
                                <td><?php echo isset($row['QT']) ? $row['QT'] : ''; ?></td>
                                <td>&lt; 400 ms</td>
                            </tr>
                            <tr>
                                <td>PR</td>
                                <td><?php echo isset($row['PR']) ? $row['PR'] : ''; ?></td>
                                <td>138 ms</td>
                            </tr>
                            <tr>
                                <td>P</td>
                                <td><?php echo isset($row['P']) ? $row['P'] : ''; ?></td>
                                <td>&lt; 100 ms</td>
                            </tr>
                            <tr>
                                <td>RR</td>
                                <td><?php echo isset($row['RR_PP']) ? $row['RR_PP'] : ''; ?></td>
                                <td>&lt; 750 ms</td>
                            </tr>
                            <tr>
                                <td>P/QRS/T</td>
                                <td><?php echo isset($row['P_QRS_T']) ? $row['P_QRS_T'] : ''; ?></td>
                                <td>&lt; 100 degree</td>
                            </tr>
                            <tr>
                                <td>QTD/QTcBD</td>
                                <td><?php echo isset($row['QTD_QTcBD']) ? $row['QTD_QTcBD'] : ''; ?></td>
                                <td>&lt; 80 ms</td>
                            </tr>
                            <tr>
                                <td>Sokolow</td>
                                <td><?php echo isset($row['Sokolow']) ? $row['Sokolow'] : ''; ?></td>
                                <td>1.3 - 3.5 mV</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td><?php echo isset($row['Type']) ? $row['Type'] : ''; ?></td>
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
       </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-CZbIe4Mp3DvCkc7Yk90A3rD/SHwVuviQIHUiUuWf4dZl5PujRQUGJlgsJq+riMbsTV6NzEgi+Ka2HLhWgdXUew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
require_once 'include/footer.php';
?>
