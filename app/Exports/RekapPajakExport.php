<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class RekapPajakExport implements WithMultipleSheets
{
    use Exportable;

    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

       
        foreach ($this->data as $key => $value) {
            if ($key == 'UP') {
                # code...
                 $sheets[] = new UpExport($value);
            }elseif ($key == 'LS') {
                # code...
                $sheets[] = new LsExport($value);
            }elseif ($key == 'GU') {
                # code...
                $sheets[] = new GuExport($value);
            }elseif ($key == 'TU') {
                # code...
                $sheets[] = new TuExport($value);
            }
        }
        return $sheets;
    }
}
