<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToCollection,WithMultipleSheets 
{
    use Importable;
    
    private $namaSheets = null;
    // public function __construct($namasheet)
    // {
    //     $this->namaSheets = $namasheet;
    // }
    public function setNamaSheet($namaSheet)
    {
        $this->namaSheets = $namaSheet;
    //    return $this->namaSheets ;
    }

    public function sheets(): array
    {
        
        // return [
        //   $this->namaSheets => $this,
    
        //  ];
        return [
           'UP, GU, TU, dan LS' => $this,
           'LS Gaji dan TPP (Template)' => $this,
            
        ];
        
        
    }
    public function collection(Collection $rows)
    {
      
    }
   
   
      
}