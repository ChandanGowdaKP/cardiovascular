<?php
require('libs/fpdf.php');
require_once 'config/connection.php';

session_start();
if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}
if (!empty($_SESSION['username'])) {
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

class PDF extends FPDF
{
    function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Title
        $this->Cell(0, 10, 'TMT TRANSACTION Report', 0, 1, 'C');
        // Line break
        $this->Ln(10);
    }

    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Instantiate PDF object
$pdf = new PDF('L'); // 'L' specifies landscape orientation
$pdf->AliasNbPages();
$pdf->AddPage();

// Add content
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Patient Name: ' . $username, 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35, 10, 'Stage', 1, 0, 'C');
$pdf->Cell(35, 10, 'Stage Time', 1, 0, 'C');
$pdf->Cell(35, 10, 'Speed (Kmph)', 1, 0, 'C');
$pdf->Cell(35, 10, 'HR', 1, 0, 'C');
$pdf->Cell(35, 10, 'BP', 1, 0, 'C');
$pdf->Cell(35, 10, 'METS', 1, 1, 'C');

$stages = array(
    array('Pre-test', '00:12', '0.00', $row['Pretesthr'], $row['Pretestbp'], $row['Pretestmets']),
    array('Supine', '00:05', '0.00', $row['Supinehr'], $row['Supinebp'], $row['Supinemets']),
    array('Standing', '00:05', '0.00', $row['Standinghr'], $row['Standingbp'], $row['Standingmets']),
    array('HyperVentilation', '00:05', '0.00', $row['Hyperhr'], $row['Hyperbp'], $row['Hypermets']),
    array('Wait for exercise', '00:05', '0.00', $row['Waithr'], $row['Waitbp'], $row['Waitmets']),
    array('Exercise stage 1', '03:00', '2.70', $row['Ex1hr'], $row['Ex1bp'], $row['Ex1mets']),
    array('Exercise stage 2', '03:00', '4.00', $row['Ex2hr'], $row['Ex2bp'], $row['Ex2mets']),
    array('Exercise stage 3', '03:00', '5.50', $row['Ex3hr'], $row['Ex3bp'], $row['Ex3mets']),
    array('Recovery 1', '01:00', '0.00', $row['Recoveryhr'], $row['Recoverybp'], $row['Recoverymets']),
    array('Recovery 2', '03:00', '0.00', $row['Recovery2hr'], $row['Recovery2bp'], $row['Recovery2mets'])
);

foreach ($stages as $stage) {
    $pdf->Cell(35, 10, $stage[0], 1, 0, 'C');
    $pdf->Cell(35, 10, $stage[1], 1, 0, 'C');
    $pdf->Cell(35, 10, $stage[2], 1, 0, 'C');
    $pdf->Cell(35, 10, $stage[3], 1, 0, 'C');
    $pdf->Cell(35, 10, $stage[4], 1, 0, 'C');
    $pdf->Cell(35, 10, $stage[5], 1, 1, 'C');
}

$pdf->Cell(0, 10, 'Total Exercise Time: ' . $row['Total_exercise_time'], 0, 1);
$pdf->Cell(0, 10, 'Max HR: ' . $row['Max_hr'], 0, 1);
$pdf->Cell(0, 10, 'Max BP: ' . $row['Max_bp'], 0, 1);
$pdf->Cell(0, 10, 'Max Workload: ' . $row['Max_workload'], 0, 1);
$pdf->Cell(0, 10, 'Distance Covered: ' . $row['Distance_covered'], 0, 1);

$pdf->Output();
?>
