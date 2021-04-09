<?php
session_start();
require_once "../../init/db.php";
require_once "../../init/functions.php";
require_once  "../../init/fpdf/fpdf.php";

if (isAlumnus()) {
	$stmt = $con->prepare("SELECT alu_name AS name FROM alumni WHERE id = ? LIMIT 1");
} elseif ( isLecturer() ) {
	$stmt = $con->prepare("SELECT lec_name AS name FROM lecturers WHERE id = ? LIMIT 1");
} else {
	redirect("public");
}

$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();
$name = $user['name'];

$pdf = new FPDF();
$pdf->AddPage("L");
$pdf->Image(asset("Images/certificate_template.jpg"), 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
$pdf->SetFont('Arial', 'B', 32);
$pdf->SetTextColor("177", "127", "74");
$pdf->SetY(85);
$pdf->SetX(32);
$pdf->Cell(1000, 10, $name);

$pdf->SetFont('Arial', 'B', 24);
$pdf->SetY(115);
$pdf->SetX(32);
$pdf->Cell(1000, 10, $_GET['course']);

$pdf->Output();

