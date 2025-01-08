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
INNER JOIN ecg ON patient_profile.UHID = ecg.UHID 
WHERE patient_profile.username = '$username'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Patient ECG Report not found.";
    exit;
}

class PDF extends FPDF
{
    function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Title
        $this->Cell(0, 10, 'Electro Cardio Gram', 0, 1, 'C');
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
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Add content
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Patient Name: ' . $username, 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Measurement Result', 1, 0, 'C');
$pdf->Cell(45, 10, 'Your Value', 1, 0, 'C');
$pdf->Cell(45, 10, 'Normal Values', 1, 1, 'C');

$measurements = array(
    array('QRS', $row['QRS'], '< 90 ms'),
    array('QT/QTcB', $row['QT'], '< 400 ms'),
    array('PR', $row['PR'], '138 ms'),
    array('P', $row['P'], '< 100 ms'),
    array('RR', $row['RR_PP'], '< 750 ms'),
    array('P/QRS/T', $row['P_QRS_T'], '< 100 degree'),
    array('QTD/QTcBD', $row['QTD_QTcBD'], '< 80 ms'),
    array('Sokolow', $row['Sokolow'], '1.3 - 3.5 mV'),
    array('Type', $row['Type'], ''),
);

foreach ($measurements as $measurement) {
    $pdf->Cell(100, 10, $measurement[0], 1);
    $pdf->Cell(45, 10, $measurement[1], 1);
    $pdf->Cell(45, 10, $measurement[2], 1, 1);
}

$pdf->Ln(10);

// Add image if available
if (isset($row['File']) && !empty($row['File'])) {
    $imagePath = 'images/' . $row['File'];
    $pdf->Cell(0, 10, 'ECG Image:', 0, 1);
    $pdf->Image($imagePath, 20, $pdf->GetY(), 170, 80);
} else {
    $pdf->Cell(0, 10, 'No image available', 0, 1);
}

$pdf->Output();
?>
