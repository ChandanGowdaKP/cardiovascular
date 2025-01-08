<?php
session_start();
require_once 'config/connection.php';


if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}
if (isset($_POST['add'])) {
    $UHID = $_POST['UHID'];
    $Symptom_ID = $_POST['Symptom_ID'];
    $date = date('Y-m-d H:i:s');
    if (mysqli_query($conn, "INSERT INTO patient_symptoms (UHID, SymptomID, Date_created) VALUES ('$UHID', '$Symptom_ID', '$date')")) {
        echo "<script>alert('Patient Symptom added successfully.');location.href='patient_symptoms.php';</script>";
    } else {
        echo "<script>alert('Unable to add Patient Symptom.');</script>";
    }
}

if (isset($_POST['update'])) {

    $UHID = $_POST['UHID'];
    $Symptom_ID = $_POST['Symptom_ID'];
    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "UPDATE patient_symptoms SET UHID = '$UHID', SymptomID = '$Symptom_ID', Date_created ='$date' WHERE Patient_symptom_ID = '$_POST[id]'")) {

        echo "<script>alert('Patient Symptom updated successfully.');location.href='patient_symptoms.php';</script>";
    } else {
        echo "<script>alert('Unable to update Patient Symptom.');location.href='patient_symptoms.php';</script>";
    }
}

if (isset($_POST['delete'])) {

    if (mysqli_query($conn, "DELETE FROM patient_symptoms WHERE Patient_symptom_ID = '$_POST[did]'")) {
        echo "<script>alert('Patient Symptom deleted successfully.');location.href='patient_symptoms.php';</script>";
    } else {
        echo "<script>alert('Unable to delete Patient Symptom.');location.href='patient_symptoms.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Symptoms</title>
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
            <h1 class="display-3 text-white mb-3 animated slideInDown">Patient Symptoms</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Patient Symptoms</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="modal fade" id="addPatientsModal" tabindex="-1" aria-labelledby="addPatientsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPatientsModalLabel">Add Patient Symptoms</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3">

                                <select class="form-control" id="UHID" name="UHID" style="max-width: 400px;">
                                    <option value="">Select Patient</option>
                                    <?php
                                    $res1 = mysqli_query($conn, "SELECT UHID, username FROM patient_profile");
                                    if (mysqli_num_rows($res1) > 0) {
                                        while ($row = mysqli_fetch_assoc($res1)) {
                                            echo "<option value='$row[UHID]'>$row[username]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                            <select class="form-control" id="symptom" name="Symptom_ID" style="max-width: 400px;">
                                <option value="">Select Symptom</option>
                                <?php
                                $res2 = mysqli_query($conn, "SELECT Symptom_ID, Symptom FROM symptoms");
                                if (mysqli_num_rows($res2) > 0) {
                                    while ($row = mysqli_fetch_assoc($res2)) {
                                        echo "<option value='" . $row['Symptom_ID'] . "'>" . $row['Symptom'] . "</option>";
                                    }
                                }
                                ?>
                            </select>


                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary" name="add">Save</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800" style="text-align: center;">Manage Patient Symptoms</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPatientsModal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add Patient Symptoms
                </a>
            </div>
            <div class="table-responsive">
                <style>
                    .custom-table th,
                    .custom-table td {
                        padding: 0.5rem;
                        font-size: 14px;
                    }
                </style>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Patient name</th>
                                    <th>Symptoms</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resData = mysqli_query($conn, "SELECT ps.*, pp.username AS PatientName, s.Symptom 
                                FROM patient_symptoms ps 
                                JOIN patient_profile pp ON ps.UHID = pp.UHID 
                                JOIN symptoms s ON ps.SymptomID = s.Symptom_ID 
                                ORDER BY ps.Patient_symptom_ID DESC");
                                if (mysqli_num_rows($resData) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($resData)) {
                                        echo "<tr>";
                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row['PatientName'] . "</td>";
                                        echo "<td>" . $row['Symptom'] . "</td>";
                                        echo "<td>";
                                ?>
                                        <form method="POST">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#editPatientsModal<?php echo $row['Patient_symptom_ID']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <input type="hidden" name="did" value="<?php echo $row['Patient_symptom_ID']; ?>" />
                                            <button name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                <?php
                                        echo "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                $resData = mysqli_query($conn, "SELECT * FROM patient_symptoms");
                if (mysqli_num_rows($resData) > 0) {
                    while ($row = mysqli_fetch_assoc($resData)) {
                ?>
                        <div class="modal fade" id="editPatientsModal<?php echo $row['Patient_symptom_ID']; ?>" tabindex="-1" aria-labelledby="editPatientsModalLabel<?php echo $row['Patient_symptom_ID']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPatientsModalLabel<?php echo $row['Patient_symptom_ID']; ?>">Edit Patient Symptoms</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <select class="form-control" id="UHID" name="UHID" style="max-width: 400px;">
                                                    <option value="">Select Patient Name</option>
                                                        <?php
                                                        $res1 = mysqli_query($conn, "SELECT UHID, username FROM patient_profile");
                                                        if (mysqli_num_rows($res1) > 0) {
                                                            while ($patient = mysqli_fetch_assoc($res1)) {
                                                                $selected = ($patient['UHID'] == $row['UHID']) ? 'selected' : '';
                                                                echo "<option value='" . $patient['UHID'] . "' $selected>" . $patient['username'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <select class="form-control" id="symptom" name="Symptom_ID" style="max-width: 400px;">
                                                    <option value="">Select Symptom</option>
                                                        <?php
                                                        $res2 = mysqli_query($conn, "SELECT Symptom_ID, Symptom FROM symptoms");
                                                        if (mysqli_num_rows($res2) > 0) {
                                                            while ($symptom = mysqli_fetch_assoc($res2)) {
                                                                $selected = ($symptom['Symptom_ID'] == $row['SymptomID']) ? 'selected' : '';
                                                                echo "<option value='" . $symptom['Symptom_ID'] . "' $selected>" . $symptom['Symptom'] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="<?php echo $row['Patient_symptom_ID']; ?>">
                                                <button type="submit" class="btn btn-outline-primary" name="update">Save</button>
                                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div> 
    </div> 

</body>
<?php require_once 'include/footer.php'; ?>

</html>
