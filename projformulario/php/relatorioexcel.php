<?php
require_once('tcpdf/tcpdf.php');

class PDF extends TCPDF {
    public function Header() {
        // Adicione cabeçalho do PDF aqui
    }

    public function Footer() {
        // Adicione rodapé do PDF aqui
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Adicione conteúdo do relatório aqui

$pdf->Output('relatorio.pdf', 'D');
?>

<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Adicione dados ao arquivo Excel aqui

$writer = new Xlsx($spreadsheet);
$writer->save('relatorio.xlsx');
?>
