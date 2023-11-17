<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

use Illuminate\Support\Arr;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TuExport implements FromArray, WithTitle,WithHeadings,WithStyles,WithCustomStartCell,WithEvents
{
    private $data;
    private $jum = null;
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->jum=count($data);
    }

    /**
     * @return Builder
     */
    public function array(): array
    {
     
        $list = array_map(function ($item) {
            return Arr::except($item, ['jenis']);
        }, $this->data);
        return $list;
    }

    public function startCell(): string
    {
        return 'B4';
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'TU';
    }

        
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $columns = ["B", "D","J"];
                $columnIndex = ["C", "E","H"]; //kolom number
                foreach ($columns as $column) {
                    if ($column == "B") {
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(30);
                    }else{
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(50);
                    }
                }
                $columnsAutoSize = ["C", "E","F","G","H","I","K"];
                foreach ($columnsAutoSize as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
                $event->sheet->getStyle('B3:K'.$this->jum+4)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ])->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

                foreach ($columnIndex as $column) {
                    $event->sheet->getStyle($column . '5:' . $column . ($event->sheet->getHighestRow()))
                    ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }
            

                $event->sheet->getDelegate()->getStyle('B3:K3')
                ->getFont()
                ->setBold(true);
                $event->sheet->getDelegate()->getStyle('B4:K4')
                ->getFont()
                ->setBold(true);

                $event->sheet->getDelegate()->mergeCells('B3:C3');
                $event->sheet->setCellValue('B3', 'TU');
                $event->sheet->getDelegate()->mergeCells('D3:D4');
                $event->sheet->setCellValue('D3', 'URAIAN BELANJA');
                $event->sheet->getDelegate()->mergeCells('E3:H3');
                $event->sheet->setCellValue('E3', 'POTONGAN PAJAK');
                $event->sheet->getDelegate()->mergeCells('I3:I4');
                $event->sheet->setCellValue('I3', 'NPWP REKANAN / BENDAHARA');
                $event->sheet->getDelegate()->mergeCells('J3:J4');
                $event->sheet->setCellValue('J3', 'NAMA SKPD');
                $event->sheet->getDelegate()->mergeCells('K3:K4');
                $event->sheet->setCellValue('K3', 'NTPN');
                $event->sheet->getDelegate()->getStyle('B3')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('E3')
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B3:K3')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('CECECE');
                $event->sheet->getDelegate()->getStyle('B4:K4')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('CECECE');

            },
        ];
    }
    public function headings(): array
    {
        return ["NOMOR TBP/ KWT", "NILAI BELANJA", "URAIAN BELANJA" ,"DASAR PENGENAAN PAJAK",
        "KODE AKUN", "JENIS PAJAK" ,"JUMLAH PAJAK", "NPWP REKANAN / BENDAHARA","NAMA SKPD","NTPN"];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            // 1    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}