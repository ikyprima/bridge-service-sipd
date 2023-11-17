<?php

namespace App\Exports;


use Modules\Pajak\Entities\TbRekapPajak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PajakExport implements FromCollection,WithHeadings,WithStyles,WithCustomStartCell,WithEvents,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $jum = null;
    public function __construct(array $data)
    {
        $this->tahun = $data['tahun'];
        $this->bulan = $data['bulan'];
        $this->jenis = $data['jenis'];
        $this->id_skpd = $data['id_skpd'];
    }
    
public function registerEvents(): array
{


    return [
        AfterSheet::class => function(AfterSheet $event) {
            // $columns = ["B", "C", "D", "E", "F", "G", "H", "I", "J", "K"];
            // foreach ($columns as $column) {
            //     $event->sheet->getColumnDimension($column)->setAutoSize(true);
            // }
            $event->sheet->getStyle('B3:K'.$this->jum+4)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ])->getAlignment()->setWrapText(true);

            $event->sheet->getDelegate()->getStyle('B3:K3')
            ->getFont()
            ->setBold(true);
            $event->sheet->getDelegate()->getStyle('B4:K4')
            ->getFont()
            ->setBold(true);

            $event->sheet->getDelegate()->mergeCells('B3:C3');
            $event->sheet->setCellValue('B3', 'SP2D');
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

    public function startCell(): string
    {
        return 'B4';
    }

    public function collection()
    {   
        $collection = collect();
        $rekap = TbRekapPajak::where([
            ["tahun", $this->tahun],
            ["bulan_dokumen", $this->bulan],
            ["jenis", $this->jenis],
            ["id_skpd", $this->id_skpd],
            ["visible", 1],
            // ["ver", 1]
        ])->get()->map(function($item) use (&$collection){
            $parts = explode(".", $item->kode_rekening);
            $rekGaji = implode(".", array_slice($parts, 0, 4));
            if ($rekGaji === '5.1.01.01') {
                $itemToUpdate = $collection->firstWhere('tbp_kwt', $item->tbp_kwt);
                if ($itemToUpdate) {
                    if ($item->jenis_pajak === 'PPH 21') {
                        $itemToUpdate['id'] = $item->id;
                        $itemToUpdate['id_skpd'] = $item->id_skpd;
                        $itemToUpdate['tanggal_dokumen']= $item->tanggal_dokumen;
                        $itemToUpdate['bulan_dokumen']= $item->bulan_dokumen;
                        $itemToUpdate['jenis']= $item->jenis;
                        $itemToUpdate['tbp_kwt']= $item->tbp_kwt;
                        $itemToUpdate['nilai_belanja']  += $item->nilai_belanja;
                        $itemToUpdate['uraian_belanja']= $item->uraian_belanja;
                        $itemToUpdate['dpp']= $item->dpp;
                        $itemToUpdate['kode_akun']= $item->kode_akun;
                        $itemToUpdate['jenis_pajak']= $item->jenis_pajak;
                        $itemToUpdate['jumlah_pajak']= $item->jumlah_pajak;
                        $itemToUpdate['npwp']= $item->npwp;
                        $itemToUpdate['kode_skpd']= $item->kode_skpd;
                        $itemToUpdate['nama_skpd']= $item->nama_skpd;
                        $itemToUpdate['ntpn']= $item->ntpn;
                        $itemToUpdate['tahun']= $item->tahun;
                        $itemToUpdate['ver']= $item->ver;
                        $itemToUpdate['jenis_sipd']= $item->jenis_sipd;
                        $itemToUpdate['jenis_pajak_sipd']= $item->jenis_pajak_sipd;
                        $itemToUpdate['kode_rekening']= $item->kode_rekening;
                        $itemToUpdate['kategori_sipd']= $item->kategori_sipd;
                        $itemToUpdate['visible']= $item->visible;
                
                    }else{
                        $itemToUpdate['nilai_belanja'] += $item->nilai_belanja;        
                    }
                }else{
            
                    $collection->push($item);
                }
                
                return null;
            }else{
                return [
                                'tbp_kwt'=>$item->tbp_kwt,
                                'nilai_belanja'=>$item->nilai_belanja,
                                'uraian_belanja'=>$item->uraian_belanja,
                                'dpp'=>$item->dpp,
                                'kode_akun'=>$item->kode_akun,
                                'jenis'=>$item->jenis,
                                'jumlah_pajak'=>$item->jumlah_pajak,
                                'npwp'=>$item->npwp,
                                'nama_skpd'=>$item->nama_skpd,
                                'ntpn'=>$item->ntpn,
                            ];
            }
        })->filter();
        
        $semuaRekap = collect($rekap->merge($collection->map(function($item){
            return [
                'tbp_kwt'=>$item->tbp_kwt,
                'nilai_belanja'=>$item->nilai_belanja,
                'uraian_belanja'=>$item->uraian_belanja,
                'dpp'=>$item->dpp,
                'kode_akun'=>$item->kode_akun,
                'jenis'=>$item->jenis,
                'jumlah_pajak'=>$item->jumlah_pajak,
                'npwp'=>$item->npwp,
                'nama_skpd'=>$item->nama_skpd,
                'ntpn'=>$item->ntpn,
            ];
        })))->filter()->values();
        $this->jum=$semuaRekap->count();
        return $semuaRekap;
    }
    public function headings(): array
    {
        return ["NOMOR", "NILAI BELANJA", "URAIAN BELANJA" ,"DASAR PENGENAAN PAJAK",
        "KODE AKUN", "JENIS PAJAK" ,"JUMLAH PAJAK", "NPWP REKANAN / BENDAHARA","NAMA SKPD","NTPN"];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}
