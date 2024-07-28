<?php
require '../vendor/autoload.php'; // Include the Composer autoload file
include('db_connect.php');

// Get the selected course ID from the query string
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : '';

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
    public function Header() {
        // Logo
        $image_file = 'assets/img/logo.png'; // Update this path to your logo file
        $logo_width = 70; // Width of the logo
        $page_width = $this->getPageWidth();
        $logo_x = ($page_width - $logo_width) / 2; // Center the logo

        $this->Image($image_file, $logo_x, 10, $logo_width, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('List of Alumni');
$pdf->SetSubject('Alumni Report');
$pdf->SetKeywords('TCPDF, PDF, alumni, report');

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 20, PDF_MARGIN_RIGHT); // Adjust top margin to accommodate logo
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Generate HTML content
$html = '<table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Course Graduated</th>
                    <th>Year of Graduation</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>';

$i = 1;
$query = "SELECT a.*, c.course, CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) as name 
          FROM alumnus_bio a 
          INNER JOIN courses c ON c.id = a.course_id";
if ($course_id != '') {
    $query .= " WHERE a.course_id = '$course_id'";
}
$query .= " ORDER BY CONCAT(a.lastname, ', ', a.firstname, ' ', a.middlename) ASC";

$alumni = $conn->query($query);
while ($row = $alumni->fetch_assoc()) {
    $status = $row['status'] == 1 ? 'Verified' : 'Not Verified';
    $html .= '<tr>
                <td>'.ucwords($row['name']).'</td>
                <td>'.$row['course'].'</td>
                <td>'.$row['batch'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['mobileNumber'].'</td>
              </tr>';
}

$html .= '</tbody></table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('alumni_list.pdf', 'I');
?>