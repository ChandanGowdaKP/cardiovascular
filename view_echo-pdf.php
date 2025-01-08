<?php
require('libs/fpdf.php');
require_once 'config/connection.php';

session_start();
if(!isset($_SESSION['isLogin'])){
    header("Location: login.php");
    exit();
}

// Fetch data from the database
$sql = "SELECT e.*, t.Descriptive_Details
        FROM echo e
        JOIN tempdescdetails t ON e.UHID = t.UHID
        WHERE e.UHID";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Fetch the row as an associative array
$row = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);

class PDF extends FPDF
{
    function Header()
    {
        // Select Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Title
        $this->Cell(0, 10, 'View ECHO Report', 0, 1, 'C');
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

$pdf->Cell(0, 10, 'DEPARTMENT OF CARDIAC DIAGNOSIS', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'ECHO COLOR DOPPLER', 0, 1);
$pdf->Ln(5);

// Measurements Table
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Parameters', 1, 0, 'C');
$pdf->Cell(40, 10, 'Value', 1, 0, 'C');
$pdf->Cell(40, 10, 'Normal Value', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$measurements = array(
    array('Aortic root', isset($row['Aortic_Root']) ? $row['Aortic_Root'] : '', '20-37 mm'),
    array('Left Atrium', isset($row['Left_Atrium']) ? $row['Left_Atrium'] : '', '19-35 mm'),
    array('IVSd (Mild)', isset($row['IVSd']) ? $row['IVSd'] : '', '6-11 mm'),
    array('LVPWd', isset($row['LVPWd']) ? $row['LVPWd'] : '', '6-11 mm'),
    array('LVIDd', isset($row['LVIDd']) ? $row['LVIDd'] : '', '34-52 mm'),
    array('LVIDs', isset($row['LVIDs']) ? $row['LVIDs'] : '', '23-38 mm'),
    array('LVEF', isset($row['LVEF']) ? $row['LVEF'] : '', '50-80%')
);

foreach ($measurements as $measurement) {
    $pdf->Cell(50, 10, $measurement[0], 1);
    $pdf->Cell(40, 10, $measurement[1], 1);
    $pdf->Cell(40, 10, $measurement[2], 1, 1);
}

$pdf->Ln(10);

// Descriptive Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Descriptive details', 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 10, isset($row['Descriptive_Details']) ? $row['Descriptive_Details'] : '');

$pdf->Ln(10);

// Impression
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Impression', 0, 1);
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 10, isset($row['Impression']) ? $row['Impression'] : '');

$pdf->Ln(10);

// Add a page number
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 1, 'C');

$pdf->Output();
?>
