<?php

namespace Modules\Pajak\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\PajakExport;
use App\Exports\RekapPajakExport;

use App\Models\nama_skpd;
use Modules\Pajak\Entities\TbUploadTemplatePajak;
use Modules\Pajak\Entities\TbRekapPajak;

use Inertia\Inertia;
use Illuminate\Support\MessageBag;
use Validator;
use Storage;
use Redirect;
class PajakController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $idSkpd = 36;
        $template = TbUploadTemplatePajak::where('id_skpd',$idSkpd)->first();

        if($request->has('bulan') && $request->has('tahun')){
            $bulanDokumen = date('M', mktime(0, 0, 0, $request->bulan, 1)); // Konversi angka bulan menjadi nama bulan tiga huruf
            $tahun = $request->tahun;
        }else{
            $bulanDokumen = date('M'); // Konversi angka bulan menjadi nama bulan tiga huruf
            $tahun =  date('Y');
        }
        $collection = collect();
        $rekap = TbRekapPajak::where('id_skpd',$idSkpd)
        ->where('id_skpd',$idSkpd)
        ->where('bulan_dokumen',$bulanDokumen)
        ->where('tahun',$tahun)
        ->where('visible',1)
        // ->where('tbp_kwt','08.00/03.0/000083/LS/5.02.0.00.0.00.01.0000/P.03/6/2023')
        ->get()->map(function($item) use (&$collection,&$rekeningGaji){
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
                        $itemToUpdate['rekgaji']=true;
                    }else{
                        $itemToUpdate['nilai_belanja'] += $item->nilai_belanja;        
                    }
                }else{
                    $collection->push($item);
                }
                
                return null;
            }else{
                return $item;
            }
        })->filter();
        $semuaRekap = collect($rekap->merge($collection))->sortBy('tanggal_dokumen')->filter()->values()->groupBy('jenis');
        // return $semuaRekap;

        return Inertia::render('Pajak/Index',[
            'template'=>$template,
            'dataRekap'=>$semuaRekap
        ]);

    }

    public function listRekeningGaji(Request $request){

        return TbRekapPajak::where('tbp_kwt',$request->tbp_kwt)->get();    
        
    }

    public function exportExcelPajak(Request $request){
          
        $monthNumber = $request->bulan ; // 6
        $tahun = $request->tahun;          // 2023
        $id_skpd = 36;
        $bulanDokumen = date('M', mktime(0, 0, 0, $monthNumber, 1)); // Konversi angka bulan menjadi nama bulan tiga huruf
        $collection = collect();
        $rekap = TbRekapPajak::where([
            ["tahun", $tahun],
            ["bulan_dokumen", $bulanDokumen],
            // ["jenis", 'LS'],
            ["id_skpd",  $id_skpd],
            ["ver", 1],
            ["visible",1]
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
                                'jenis_pajak'=>$item->jenis_pajak,
                                'jumlah_pajak'=>$item->jumlah_pajak,
                                'npwp'=>$item->npwp,
                                'nama_skpd'=>$item->nama_skpd,
                                'ntpn'=>$item->ntpn,
                                'jenis'=>$item->jenis,

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
                'jenis_pajak'=>$item->jenis_pajak,
                'jumlah_pajak'=>$item->jumlah_pajak,
                'npwp'=>$item->npwp,
                'nama_skpd'=>$item->nama_skpd,
                'ntpn'=>$item->ntpn,
                'jenis'=>$item->jenis,
            ];
        })))->filter()->values()->groupBy('jenis');
        if ($semuaRekap->count() > 0) {
            # code...
            return (new RekapPajakExport($semuaRekap->toArray()))->download('rekap pajak.xlsx');
        }else{
            $errors = new MessageBag(['error' =>  'Tidak ada data yang diexport',
            'pesan'=> 'Terjadi Kesalahan ']);
            return Redirect::back()->withErrors($errors);
        }
       
      
      
        
        //-----------------------
        //jika menggunakan collection langsung ke class PajakExport
        // $data = [
        //     'tahun'=>2023,
        //     'bulan'=>'Jun',
        //     'jenis'=>'LS',
        //     'id_skpd'=> 36
        // ];
        // $export = new PajakExport($data);
        // return Excel::download($export, 'tes.xlsx');
        //----------------------------------

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function uploadExcel(Request $request){
       
        $rules = [
            'file' => [
                'required',
                'mimes:xls,xlsx'
            ],
        ];
        $customMessages = [
            'required' => ':attribute harus di isi.',
            'unique'=> ':attribute sudah terdaftar',
            'email'=> 'format :attribute salah'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages)->validate();
        $tahun = '2023';
        $id_skpd = 36;
        $file = $request->file('file');
        $fileName = $id_skpd.'-'.$tahun . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->put('pajak'.'/'.$fileName,file_get_contents($file) , 'public');
    
       
        $upload = TbUploadTemplatePajak::updateOrCreate([
            'id_skpd' => $id_skpd,
            'tahun' => $tahun
        ], [
            'path_file' => 'pajak/'.$fileName,
            'updated_at' => now(),
        ]);

        $tahun=2023;
        //get data nama_skpd dan npwp bendahara
         $namaSkpd = nama_skpd::all();
        
        // import data dari excell 
        $import = new UsersImport();
        try {
            //code...
                //cek ke database tabel tb_rekap_pajak
                $rekapVerifikasi = tbRekapPajak::where('id_skpd',$id_skpd )->where('tahun',$tahun )->where('ver',1)->get();
                // return $rekapVerifikasi;
                    $data = Excel::toCollection($import, Storage::disk('public')->path($upload->path_file));
                
                
                    $result = collect($data['UP, GU, TU, dan LS'])->filter(function ($item)  {
                        $parts = explode(".", $item[14]);
                        $rekGaji = implode(".", array_slice($parts, 0, 4));
                        return ($rekGaji === '5.1.01.01' && $item[14] !== 'Kode Rekening' ) || $item[26] === 'pajak'  ;
                        
                    })->values()->map(function($item)use ($namaSkpd,$tahun,$rekapVerifikasi) {
                    
                    $skpd = collect($namaSkpd)->where('kode_skpd',$item[0])->values()->first();
                    $npwp = $skpd? $skpd->npwp_bendahara:null;
                    $idskpd = $skpd? $skpd->id:null;

                    if($item[27]==='PPH 21'){
                        $jenis_pajak = 'PPH 21';
                        $dpp = $item[31];
                        $kode_akun= 411121;
                        $npwpBendahara = $npwp;
                    
                    }elseif ($item[27] === 'Pajak Penghasilan Ps 22') {
                        # code...
                        $jenis_pajak = 'PPH 22';
                        $dpp = $item[31] - (11/111 *  $item[31] );
                        $kode_akun= 411122;
                        $npwpBendahara = '';
                    }elseif ($item[27] === 'Pajak Penghasilan Ps 23') {
                        # code...
                        $jenis_pajak = 'PPH 23';
                        $dpp = 100/2 * $item[28];
                        $kode_akun= 411124;
                        $npwpBendahara = $npwp;
                    }elseif ($item[27] === 'Pajak Pertambahan Nilai') {
                        # code...
                        $jenis_pajak = 'PPN';
                        $dpp = 100/111 * $item[31];
                        $kode_akun= 411211;
                        $npwpBendahara = $npwp;
                        
                    }elseif ($item[27] === 'Pajak Penghasilan Ps 25') {
                        # code...
                        $jenis_pajak = 'PPH 25';
                        $dpp = '';
                        $kode_akun= 411125;
                        $npwpBendahara = $npwp;
                        
                    }else{
                        $jenis_pajak = $item[27];
                        $dpp = '';
                        $kode_akun= null;
                        $npwpBendahara = '';
                    }
                    if ($rekapVerifikasi->contains('tbp_kwt', $item[22]) && $rekapVerifikasi->contains('jenis_pajak', $jenis_pajak) ) {
                        # code...
                        return null;
                    }
                
                    return [
                        "id_skpd"=> $idskpd,
                        "tanggal_dokumen"=>$item[23],
                        "bulan_dokumen"=>$item[24],
                        "jenis"=>$item[21] ,
                        "tbp_kwt" =>$item[22],
                        "nilai_belanja"=>$item[31],
                        "uraian_belanja"=>$item[25],
                        "dpp"=> number_format((float)$dpp, 2, '.', '') ,
                        "kode_akun"=>$kode_akun,
                        "jenis_pajak"=>$jenis_pajak,
                        "jumlah_pajak"=>$item[28],
                        "npwp"=>$npwpBendahara,
                        "kode_skpd"=>$item[0],
                        "nama_skpd"=>$item[1],
                        "ntpn"=>$item[30],
                        "tahun"=>$tahun,
                        "jenis_sipd" =>$item[21],
                        "jenis_pajak_sipd"=>$item[27],
                        "kode_rekening"=>$item[14],
                        "kategori_sipd" =>$item[26]
                    ];
                })->filter()->values();
                    # code...
                   

                    $LSGaji = collect($data['LS Gaji dan TPP (Template)'])->filter(function ($item)  {
                        return  $item[7] === 'PPH 21';
                    })->values()->map(function($item) use ($namaSkpd,$tahun,$rekapVerifikasi){
                        $skpd = collect($namaSkpd)->where('kode_skpd',$item[0])->values()->first();
                        $npwp = $skpd->npwp_bendahara;
                        $idskpd = $skpd->id;
                        $jenis_pajak = 'PPH 21';
                        $dpp = $item[11];
                        $kode_akun= 411121;
                        $npwpBendahara = $npwp;
                        if ($rekapVerifikasi->contains('tbp_kwt', $item[20]) && $rekapVerifikasi->contains('jenis_pajak', $jenis_pajak) ) {
                            # code...
                            return null;
                        }
                        return [
                            "id_skpd"=>$idskpd,
                            "tanggal_dokumen"=>$item[4],
                            "bulan_dokumen"=>$item[5],
                            "jenis"=>'LS',
                            "tbp_kwt" =>$item[20],
                            "nilai_belanja"=>$item[11],
                            "uraian_belanja"=>$item[6],
                            "dpp"=> number_format((float)$dpp, 2, '.', '') ,
                            "kode_akun"=>$kode_akun,
                            "jenis_pajak"=>$jenis_pajak,
                            "jumlah_pajak"=>$item[8],
                            "npwp"=>$npwpBendahara,
                            "kode_skpd"=>$item[0],
                            "nama_skpd"=>$item[1],
                            "ntpn"=>null,
                            "tahun"=>$tahun,
                            "jenis_sipd" =>$item[2],
                            "jenis_pajak_sipd"=>$item[7],
                            "kode_rekening"=>null,
                            "kategori_sipd" =>null
                        ];
                    })->filter()->values();
           
                   $semuaLS = $result->merge($LSGaji);
                
                    tbRekapPajak::where('id_skpd',$id_skpd )->where('tahun',$tahun )
                    ->whereNotIn('id',$rekapVerifikasi->pluck('id'))
                    ->delete();
                    tbRekapPajak::insert($semuaLS->toArray());
                    return back(303);
               
            
            

        } catch (\Exception $th) {
            //throw $th;
            $isInertiaRequest =$request->header('X-Inertia') === 'true';
            if ($isInertiaRequest) {
                return $th->getMessage();
                $errors = new MessageBag(['error' =>  $th->getMessage(),
                'pesan'=> 'Terjadi Kesalahan ']);
                return Redirect::back()->withErrors($errors);
            } else {
                return ['error' =>  $th->getMessage(),
                'pesan'=> 'Terjadi Kesalahan '];
               
            }
           
          
        }
        
        
    } 

    public function excelImport (Request $request){ 
       
        // $monthNumber = $request->month['month'] + 1; // 6
        // $tahun = $request->month['year'];          // 2023
        // $id_skpd = 36;
        // $dataFile = TbUploadTemplatePajak::where([['id_skpd',$id_skpd],['tahun',$tahun]])->first();
        // $bulanDokumen = date('M', mktime(0, 0, 0, $monthNumber, 1)); // Konversi angka bulan menjadi nama bulan tiga huruf
        // $dataRekap = tbRekapPajak::where('id_skpd',$id_skpd)
        // ->where('bulan_dokumen',$bulanDokumen)
        // ->where('tahun',$tahun)
        // ->get()->groupBy('jenis');
        // return $dataRekap;
        // return redirect()->back()->with( [
        //     'template'=>$dataFile,
        //     'dataRekap'=>$dataRekap
        // ]); 
     
      
        // return Inertia::render('Pajak/Index',[
        //     'template'=>$dataFile,
        //     'dataRekap'=>$dataRekap
        // ]);


    }

    public function updateVerifikasi(Request $request, $id){
        
        if($request->tbp != null){
            tbRekapPajak::where("tbp_kwt", $request->tbp)->update(["ver" =>  $request->ver]);
        }else{
            tbRekapPajak::where("id", $id)->update(["ver" =>  $request->ver]);
        }
    
        
        return back(303);
    }
    public function updateVisible(Request $request, $id){
      
       return tbRekapPajak::where("id", $id)->update(["visible" =>  $request->visible]);
        // return true;
    //    return back(303);
   }

    
    public function create()
    {
        return view('pajak::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('pajak::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('pajak::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $value =  [
            "tbp_kwt" =>$request->nomorTbp,
            "nilai_belanja"=>$request->nilaiBelanja,
            "uraian_belanja"=>$request->uraianBelanja,
            "dpp"=>$request->dpp,
            "kode_akun"=>$request->kodeAkun,
            "jenis_pajak"=>$request->jenisPajak,
            "jumlah_pajak"=>$request->jumlahPajak,
            "npwp"=>$request->npwp,
            "ntpn"=>$request->ntpn,
            "ver" =>$request->verifikasi,
        ];

        if ($request->rekgaji === true) {
            unset($value['nilai_belanja']);
        }
        
        tbRekapPajak::where("id", $id)
        ->update(
           $value
        );
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
