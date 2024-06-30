<?php
// Include the PhpSpreadsheet classes
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

// Your database connection and data fetching logic
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

// SQL query to fetch data from the assigntask table and join with similarity table
$query = "SELECT assigntask.*, similarity.similaritypercent, similarity.review1, similarity.review2 
          FROM assigntask 
          LEFT JOIN similarity ON assigntask.ID = similarity.ID";

$result = mysqli_query($conn, $query);

// Fetch data and store it in an array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Define column headers
$sheet->setCellValue('A1', 'Institution');
$sheet->setCellValue('B1', 'Programme');
$sheet->setCellValue('C1', 'Degree Course ');
$sheet->setCellValue('C2', 'Degree Course Code');
$sheet->setCellValue('D2', 'Degree Course Name');
$sheet->setCellValue('E1', 'Diploma Course');
$sheet->setCellValue('E2', 'Diploma Course Code');
$sheet->setCellValue('F2', 'Diploma Course Name');
$sheet->setCellValue('G2', 'Diploma Credit Hour');
$sheet->setCellValue('H1', 'Syllabus Overlap%');
$sheet->setCellValue('I1', 'Review');

// Merge header cells and set styles
$sheet->mergeCells('A1:A2');
$sheet->mergeCells('B1:B2');
$sheet->mergeCells('C1:D1');
$sheet->mergeCells('E1:G1');
$sheet->mergeCells('H1:H2');
$sheet->mergeCells('I1:I2');
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C0C0C0']],
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
];
$sheet->getStyle('A1:I2')->applyFromArray($headerStyle);

// Adjust column widths
$sheet->getColumnDimension('A')->setWidth(50);
$sheet->getColumnDimension('B')->setWidth(50);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(30);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(20);
$sheet->getColumnDimension('I')->setWidth(50);

// Populate data
$rowNumber = 3; // Start from the next row after the header
foreach ($data as $row) {
    $sheet->setCellValue('A' . $rowNumber, $row['dipprev_inst']);
    $sheet->setCellValue('B' . $rowNumber, $row['dipprev_prog']);
    $sheet->setCellValue('C' . $rowNumber, $row['degcode']);
    $sheet->setCellValue('D' . $rowNumber, $row['degcourse']);
    $sheet->setCellValue('E' . $rowNumber, $row['dipcode']);
    $sheet->setCellValue('F' . $rowNumber, $row['dipcourse']);
    $sheet->setCellValue('G' . $rowNumber, $row['dipcredithour']);

    // Handle null values for similaritypercent
    if (!is_null($row['similaritypercent'])) {
        $sheet->setCellValue('H' . $rowNumber, $row['similaritypercent'] . '%');
    } else {
        $sheet->setCellValue('H' . $rowNumber, 'In Progress');
    }

    // Create a RichText object for the cell value
    $richText = new RichText();

    // Add "Sme 1's Review:" in bold if review1 is not null
    if (!is_null($row['review1'])) {
        $boldRun1 = $richText->createTextRun("Sme 1's Review: ");
        $boldRun1->getFont()->setBold(true);
        $richText->createText($row['review1'] . "\n");
    } else {
        $boldRun1 = $richText->createTextRun("Sme 1's Review: ");
        $boldRun1->getFont()->setBold(true);
        $richText->createText("In Progress\n");
    }

    // Add "Sme 2's Review:" in bold if review2 is not null
    if (!is_null($row['review2'])) {
        $boldRun2 = $richText->createTextRun("Sme 2's Review: ");
        $boldRun2->getFont()->setBold(true);
        $richText->createText($row['review2']);
    } else {
        $boldRun2 = $richText->createTextRun("Sme 2's Review: ");
        $boldRun2->getFont()->setBold(true);
        $richText->createText("In Progress");
    }

    // Set the RichText object to the cell
    $sheet->setCellValue('I' . $rowNumber, $richText);
    // Enable text wrapping
    $sheet->getStyle('I' . $rowNumber)->getAlignment()->setWrapText(true);

    $rowNumber++;
}

// Set alignment for all cells
$alignment = [
    'horizontal' => Alignment::HORIZONTAL_CENTER,
    'vertical' => Alignment::VERTICAL_CENTER,
];
$sheet->getStyle('A1:I' . ($rowNumber - 1))->getAlignment()->applyFromArray($alignment);

$filename = 'Dci_Records_' . date('d-m-y') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Save the Excel file to php://output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

