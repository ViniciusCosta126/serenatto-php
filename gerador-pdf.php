<?php

require_once('vendor/autoload.php');


use Dompdf\Dompdf;


$domPdf = new Dompdf();

ob_start();
require "conteudo-pdf.php";

$html = ob_get_clean();

$domPdf->loadHtml($html);

$domPdf->setPaper('A4');

// Render the HTML as PDF
$domPdf->render();

// Output the generated PDF to Browser
$domPdf->stream();
