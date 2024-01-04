<?php

require 'dompdf/vendor/autoload.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if student HTML content is provided in the POST request
    $htmlTemplate = file_get_contents('php://input');

    // Initialize DOMPDF
    $dompdf = new Dompdf\Dompdf();

    // Load HTML content
    // syntax: void Dompdf::loadHtml(string $html)
    $dompdf->loadHtml($htmlTemplate);

    // Set paper size and orientation (e.g., A4 portrait)
    // syntax: void Dompdf::setPaper(string $size, string $orientation = 'portrait')
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // The stream method sends the generated PDF content to the client's browser.
    $pdfFileName = 'user_registration_details.pdf';
    $dompdf->stream($pdfFileName);
}
?>