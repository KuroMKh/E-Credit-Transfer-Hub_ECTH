<?php
session_start();

// Including TCPDF library
require_once ('tcpdf/tcpdf.php');

// Check if the session variable exists and contains data
if (isset($_SESSION['pdf_data']) && !empty($_SESSION['pdf_data']) && isset($_SESSION['matrixnumber'])) {
    // Get the data from the session variable
    $data = $_SESSION['pdf_data'];
    $matrixnumber = $_SESSION['matrixnumber']; // Fetch matrix number from session
    $fullname = $_SESSION['fullname'];
    $programme = $_SESSION['programme'];
    $faculty = $_SESSION['faculty'];
    $adm_session = $_SESSION['adm_session'];
    $year_sem = $_SESSION['year_sem'];

    // Create new PDF document
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Transfer Credit Slip');
    $pdf->SetSubject('Table Data');
    $pdf->SetKeywords('TCPDF, PDF, table, data');

    // Add a page
    $pdf->AddPage();

    // Add logo
    $logo = 'images/logounisza.jpg'; // Replace 'path/to/your/logo.png' with the actual path to your logo file
    $logoY = 14; // Adjust this value to move the logo down
    $pdf->Image($logo, 10, $logoY, 60, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    // Draw a line below the logo
    $pdf->SetLineWidth(0.5);
    $lineY = $logoY + 25; // Adjust the Y position of the line relative to the logo
    $pdf->Line(10, $lineY, 210 - 10, $lineY); // Adjust the position of the line as needed

    // Set position for student information
    $student_info_y = $lineY + 5; // Adjust this value to move the student information below the line
    $pdf->SetY($student_info_y);

    // Insert student information
    $student_info = "
    <h3>Student Information: </h3><br>
    <strong>Matrix Number:</strong> $matrixnumber<br>
    <strong>Name:</strong> $fullname<br>
    <strong>Programme:</strong> $programme<br>
    <strong>Faculty:</strong> $faculty<br>
    <strong>Semester:</strong> $year_sem<br>
    <strong>Admission Session:</strong> $adm_session</p>
    ";
    $pdf->writeHTML($student_info, true, false, true, false, '');

    $html = '<h4>Transfer Credit Courses Applied For:</h4>';
    // Fetch data from the table and format it as HTML
    $html .= '<table border="1" cellpadding="5" cellspacing="0" align="center">';
    $html .= '<tr><th style="width: 6%;"><strong>No.</strong></th><th><strong>UniSZA Course Code</strong></th><th style="width: 39%;"><strong>UniSZA Course Name</strong></th><th style="width: 15%;"><strong>UniSZA Credit Hour</strong></th><th><strong>Transfer Status</strong></th></tr>';

    $rowNumber = 1;

    // Loop through the data array and add rows to the HTML table
    foreach ($data as $row) {
        $html .= '<tr>';
        $html .= '<td align="center">' . $rowNumber . '</td>';
        $html .= '<td align="center">' . htmlspecialchars($row['degree_uniszacoursecode']) . '</td>';
        $html .= '<td align="center">' . htmlspecialchars($row['degree_uniszacoursename']) . '</td>';
        $html .= '<td align="center">' . htmlspecialchars($row['degree_uniszacredithour']) . '</td>';
        $html .= '<td align="center">' . htmlspecialchars($row['degree_status']) . '</td>';
        $html .= '</tr>';

        $rowNumber++;
    }

    $html .= '</table>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output the current date and time below the table
    $pdf->Ln(); // Add a line break
    // Set timezone to Malaysia
    date_default_timezone_set('Asia/Kuala_Lumpur');
    // Output the current date and time below the table
    $malaysia_time = date('d-m-Y H:i:s');
    $pdf->Cell(0, 10, 'Generated Time: ' . $malaysia_time, 0, 1, 'L');

    $pdf->Ln(); // Add a line break
    $pdf->SetFont('helvetica', 'I', 10); // Set font style
    $pdf->Cell(0, 10, 'This slip was computer-generated and does not require a signature.', 0, 1, 'C');

    // Set response headers for PDF output
    $pdf_filename = 'Transfer_Slip_' . $matrixnumber . '.pdf';
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $pdf_filename . '"');


    // Output the PDF to the browser
    $pdf->Output($pdf_filename, 'I');
} else {
    echo "No data available for PDF generation.";
}
