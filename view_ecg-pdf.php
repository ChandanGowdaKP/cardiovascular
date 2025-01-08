<?php
require('libs/fpdf.php');
require_once 'config/connection.php';

session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: login.php");
    exit();
}

if (empty($_GET['f_text'])) {
    $f_text = "";
} else {
    $f_text = $_GET['f_text'];
}

$sql = "SELECT * FROM ecg WHERE UHID LIKE ?";
if (isset($_GET['f_search']) && !empty($_GET['f_text'])) {
    $f_text = "%" . $_GET['f_text'] . "%";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $f_text);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No matching records found.";
            exit();
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
        exit();
    }
    $stmt->close();
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Electro Cardio Gram', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Measurement Result', 1, 0, 'C');
$pdf->Cell(45, 10, 'Your Value', 1, 0, 'C');
$pdf->Cell(45, 10, 'Normal Values', 1, 1, 'C');

$measurements = array(
    array('QRS', isset($row['QRS']) ? $row['QRS'] : '', '< 90 ms'),
    array('QT/QTcB', isset($row['QT']) ? $row['QT'] : '', '< 400 ms'),
    array('PR', isset($row['PR']) ? $row['PR'] : '', '138 ms'),
    array('P', isset($row['P']) ? $row['P'] : '', '< 100 ms'),
    array('RR', isset($row['RR_PP']) ? $row['RR_PP'] : '', '< 750 ms'),
    array('P/QRS/T', isset($row['P_QRS_T']) ? $row['P_QRS_T'] : '', '< 100 degree'),
    array('QTD/QTcBD', isset($row['QTD_QTcBD']) ? $row['QTD_QTcBD'] : '', '< 80 ms'),
    array('Sokolow', isset($row['Sokolow']) ? $row['Sokolow'] : '', '1.3 - 3.5 mV'),
    array('Type', isset($row['Type']) ? $row['Type'] : '', ''),
);

foreach ($measurements as $measurement) {
    $pdf->Cell(100, 10, $measurement[0], 1);
    $pdf->Cell(45, 10, $measurement[1], 1);
    $pdf->Cell(45, 10, $measurement[2], 1, 1);
}

$pdf->Ln(10);

if (isset($row['File']) && !empty($row['File'])) {
    $imagePath = 'images/' . $row['File'];
    $pdf->Cell(0, 10, 'ECG Image:', 0, 1);
    $pdf->Image($imagePath, 20, $pdf->GetY(), 170, 80);
} else {
    $pdf->Cell(0, 10, 'No image available', 0, 1);
}

$pdf->Output();
?>
