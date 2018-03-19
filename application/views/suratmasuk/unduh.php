<?php

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$nama_file);
header('Cache-Control: max-age=0');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

// Membuat objek spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Pembuka dan Header tabel
$sheet->setCellValue('A1', 'Rekapitulasi Surat Masuk');
$sheet->setCellValue('A2', 'Dinas Pendidikan Kabupaten Semarang');
$sheet->setCellValue('A3', $from.' hingga '.$till);
$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'Tanggal Masuk');
$sheet->setCellValue('C5', 'Nomor Surat');
$sheet->setCellValue('D5', 'Tanggal Undangan');
$sheet->setCellValue('E5', 'Asal Surat');
$sheet->setCellValue('F5', 'Perihal');
$sheet->setCellValue('G5', 'Keterangan');
$sheet->setCellValue('H5', 'Tujuan');

// Merge Cell
$sheet->mergeCells('A1:H1');
$sheet->mergeCells('A2:H2');
$sheet->mergeCells('A3:H3');

// Mengubah ukuran kolom
$sheet->getColumnDimension('A')->setWidth(4);
$sheet->getColumnDimension('B')->setWidth(13);
$sheet->getColumnDimension('C')->setWidth(17);
$sheet->getColumnDimension('D')->setWidth(13);
$sheet->getColumnDimension('E')->setWidth(25);
$sheet->getColumnDimension('F')->setWidth(25);
$sheet->getColumnDimension('G')->setWidth(40);
$sheet->getColumnDimension('H')->setWidth(20);

$no = 1;
foreach ($unduh as $row) :
  $column = $no + 5;
  $sheet->setCellValue('A'.$column, $no);
  $sheet->setCellValue('B'.$column, date_format(new DateTime($row['tanggal_data']), 'd/M/Y'));
  $sheet->getStyle('B'.$column)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
  $sheet->setCellValueExplicit(
    'C'.$column,
    $row['nomor_surat'],
    DataType::TYPE_STRING
  );
  $sheet->setCellValue('D'.$column, date_format(new DateTime($row['tanggal_undangan']), 'd/M/Y'));
  $sheet->getStyle('D'.$column)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX15);
  $sheet->setCellValue('E'.$column, $row['asal_surat']);
  $sheet->setCellValue('F'.$column, $row['perihal']);
  $sheet->setCellValue('G'.$column, $row['keterangan']);
  $sheet->setCellValue('H'.$column, $row['tujuan']);
  $no++;
endforeach;

// Mengatur wrap text pada semua cell yang dipakai
$column = $no + 4;
$sheet->getStyle('A1:H'.$column)->getAlignment()->setWrapText(true);

// Mengubah style header file
$sheet->getStyle('A1:A3')->applyFromArray(
  [
    'alignment' => [
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' => [
      'bold' => true,
    ],
  ]
);

// Mengubah style header tabel
$sheet->getStyle('A5:H5')->applyFromArray(
  [
    'alignment' => [
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' => [
      'bold' => true,
    ],
  ]
);

// Mengubah style nomor dan tanggal masuk
$sheet->getStyle('A6:B'.$column)->applyFromArray(
  [
    'alignment' => [
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
  ]
);

// Mengubah style tanggal undangan
$sheet->getStyle('D6:D'.$column)->applyFromArray(
  [
    'alignment' => [
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
  ]
);

// Menambah border di seluruh data
$sheet->getStyle('A5:H'.$column)->applyFromArray(
  [
    'borders' => [
      'allBorders' => [
        'borderStyle' => Border::BORDER_THIN,
        'color' => [
          'argb' => 'FF000000'
        ],
      ],
    ],
    'alignment' => [
      'vertical' => Alignment::VERTICAL_CENTER,
    ],
  ]
);

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

?>
