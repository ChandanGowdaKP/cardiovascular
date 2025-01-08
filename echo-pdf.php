<?php
require('libs/fpdf.php');
require_once 'config/connection.php';

class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'DEPARTMENT OF CARDIAC DIAGNOSIS', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Footer
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

session_start();
if (empty($_SESSION['isLogin'])) {
    echo "<script>alert('Kindly login to proceed');location.href='login.php';</script>";
    exit;
}
if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$sql = "SELECT * FROM patient_profile 
INNER JOIN echo ON patient_profile.UHID = echo.UHID 
WHERE patient_profile.username = '$username'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Patient ECG Report not found.";
    exit;
}

// Instantiate PDF object
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Add HTML content
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Patient Name: ' . $username, 0, 1);
$pdf->Cell(0, 10, 'Order no: ' . $row['Order_Date'], 0, 1);
$pdf->Cell(0, 10, 'Report date: ' . $row['Report_Date'], 0, 1);
$pdf->Cell(0, 10, 'Bill no/ Order no: ' . $row['BillNo_OrderNo'], 0, 1);
$pdf->Cell(0, 10, 'IPNO: ' . $row['IPNO'], 0, 1);
$pdf->Cell(0, 10, 'Bed No: ' . $row['Bed_No'], 0, 1);

$pdf->Ln(10);

$pdf->Cell(0, 10, 'ECHO COLOR DOPPLER', 0, 1);
$pdf->Cell(0, 10, 'Measurements:', 0, 1);

$pdf->Ln(5);

$pdf->Cell(60, 10, 'Parameters', 1, 0, 'C');
$pdf->Cell(60, 10, 'Value', 1, 0, 'C');
$pdf->Cell(60, 10, 'Normal Value', 1, 1, 'C');

// Add measurements data
$measurements = array(
    array('Aortic root', $row['Aortic_Root'], '20-37 mm'),
    array('Left Atrium', $row['Left_Atrium'], '19-35 mm'),
    array('IVSd (Mild)', $row['IVSd'], '6-11 mm'),
    array('LVPWd', $row['LVPWd'], '6-11 mm'),
    array('LVIDd', $row['LVIDd'], '34-52 mm'),
    array('LVIDs', $row['LVIDs'], '23-38 mm'),
    array('LVEF', $row['LVEF'], '50-80%')
);

foreach ($measurements as $measurement) {
    $pdf->Cell(60, 10, $measurement[0], 1, 0);
    $pdf->Cell(60, 10, $measurement[1], 1, 0);
    $pdf->Cell(60, 10, $measurement[2], 1, 1);
}

$pdf->Ln(10);

$pdf->Cell(0, 10, 'Descriptive Details', 0, 1);

// Add descriptive details
$query = "SELECT Descriptive_Details, Result FROM tempdescdetails WHERE UHID = '{$row['UHID']}'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($desc_row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(0, 10, $desc_row['Descriptive_Details'] . ': ' . $desc_row['Result'], 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'No descriptive details found', 0, 1);
}

$pdf->Ln(10);

$pdf->Cell(0, 10, 'Impression', 0, 1);
$pdf->MultiCell(0, 10, $row['Impression']);

$pdf->Output();
?>
