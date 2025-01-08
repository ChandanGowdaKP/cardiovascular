<?php
session_start();
require_once 'config/connection.php';


if(empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}

    if (isset($_POST['add'])) {
        $Symptom = $_POST['Symptom'];
        $date = date('Y-m-d H:i:s');
        if (mysqli_query($conn, "INSERT INTO symptoms (Symptom, Date_created) VALUES ('$Symptom', '$date')")) {
            echo "<script>alert('Symptom added successfully .');location.href='symptoms.php';</script>";
        } else {
            echo "<script>alert('Unable to add User.');location.href='symptoms.php';</script>";
        }
    }

    if (isset($_POST['update'])) {

        $Symptom = $_POST['Symptom'];
        $date = date('Y-m-d H:i:s');

        if (mysqli_query($conn, "UPDATE symptoms SET Symptom = '$Symptom', Date_created = '$date' WHERE Symptom_ID = '$_POST[id]'")) {

            echo "<script>alert('Symptom updated successfully.');location.href='symptoms.php';</script>";
        } else {
            echo "<script>alert('Unable to update Symptom.');location.href='symptoms.php';</script>";
        }
    }

    if (isset($_POST['delete'])) {

        if (mysqli_query($conn, "DELETE FROM symptoms WHERE Symptom_ID = '$_POST[did]'")) {
            echo "<script>alert('Symptom deleted successfully.');location.href='symptoms.php';</script>";
        } else {
            echo "<script>alert('Unable to delete Symptom.');location.href='symptoms.php';</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Registration</title>
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
                        <h1 class="display-3 text-white mb-3 animated slideInDown">Symptoms</h1>
                        <nav aria-label="breadcrumb animated slideInDown">
                            <ol class="breadcrumb text-uppercase mb-0">
                                <li class="breadcrumb-item"><a class="text-white" href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                                <li class="breadcrumb-item text-primary active" aria-current="page">Symptoms</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="modal fade" id="addPatientsModal" tabindex="-1" aria-labelledby="addPatientsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPatientsModalLabel">Add Symptoms</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="Symptom" name="Symptom" placeholder="Symptom" required size="10">
                                        </div>
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
                <h1 class="h3 mb-0 text-gray-800" style="text-align: center;">Manage Symptoms</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addPatientsModal">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add Symptoms
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
                            <th>Symptoms</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $resData = mysqli_query($conn, "SELECT * FROM symptoms ORDER BY Symptom_ID DESC");
                            if (mysqli_num_rows($resData) > 0) {
                                $i = 1; 
                                while ($row = mysqli_fetch_assoc($resData)) {
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['Symptom'] . "</td>";
                                    echo "<td>";
                        ?>
                            <form method="POST">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#editPatientsModal<?php echo $row['Symptom_ID']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                <input type="hidden" name="did" value="<?php echo $row['Symptom_ID']; ?>" />
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
                $resData = mysqli_query($conn, "SELECT * FROM symptoms");
                if (mysqli_num_rows($resData) > 0) {
                    while ($row = mysqli_fetch_assoc($resData)) {
            ?>
            <div class="modal fade" id="editPatientsModal<?php echo $row['Symptom_ID']; ?>" tabindex="-1" aria-labelledby="editPatientsModalLabel<?php echo $row['Symptom_ID']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPatientsModalLabel<?php echo $row['Symptom_ID']; ?>">Edit Symptoms</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="hidden" name="id" value="<?php echo $row['Symptom_ID']; ?>">
                                                <input type="text" class="form-control" id="Symptom" name="Symptom" placeholder="Symptom" value="<?php echo $row['Symptom']; ?>" size="20">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
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
<?php
require_once 'include/footer.php';
?>
