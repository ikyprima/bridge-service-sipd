<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use TokenHelper;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class sp2d extends Controller
{
    public function tesexcelimport (){ 
        // import data dari excell 
        $import = new UsersImport();
        //  $import->setNamaSheet('UP, GU, TU, dan LS');
        //convert data dari excel ke json
       $data = Excel::toCollection($import, 'tes.xlsx');
     
     
    //   $result = collect($data)->map(function($item){
          
        
    //     $result = collect();
    //     $keys = [];
    //     foreach ($item[0] as $key) {
    //         $key = str_replace(' ', '_', $key);
    //         $key = str_replace('.', '', $key);
    //         $keys[] = $key;
    //     }
      
    //     foreach ($item as $index => $row) {
    //         if ($index === 0 ) continue;  
           
    //         $entry = [];
    //         for ($i = 0; $i < count($keys); $i++) {
             
    //             // Memeriksa apakah kunci ada sebelum mengaksesnya
    //             if (isset($keys[$i])) {
                    
    //                      // Menggunakan nilai "null"  jika nilai tidak didefinisikan
    //                 $entry[$keys[$i]] = isset($row[$i]) ? $row[$i] : null;
                
    //             }
    //         }
         
    //         $result->push($entry);
    //     }

    //     return $result;
    // });
    // return collect($result['UP, GU, TU, dan LS'])->where("Bulan_Dok","Jun")
    // ->where('Jenis',"UP")
    // ->where('Kategori',"pajak")->map(function($item){
    //     return [
    //         "tbp_kwt"=>$item['Nomor_Dokumen'],
    //         "nama_skpd"=>$item['Nama_SKPD'],
    //         "nilai_belanja"=>$item['Nilai_Belanja_Rek_Bruto'],
    //         "uraian_belanja"=>$item['Keterangan_Dok'],
    //         "dpp"=>"",
    //         "kode_akun"=>"",
    //         "jenis_pajak"=>"",
    //         "jumlah_pajak"=>"",
    //         "npwp"=>"",
    //         "ntpn"=>""

    //     ];
    // })
    // ->values();
   

         $keys = $data['UP, GU, TU, dan LS'][0];
         $result = collect($data['UP, GU, TU, dan LS'])->filter(function ($item) {
            return $item[24] === "Jun" && $item[21] === 'UP' && $item[26] === 'pajak';
        })->values()  ->map(function($item){
          
            if($item[27]==='PPH 21'){
                $jenis_pajak = 'PPH 21';
                $dpp = $item[31];
                $kode_akun= 411121;
            }elseif ($item[27] === 'Pajak Penghasilan Ps 22') {
                # code...
                $jenis_pajak = 'PPH 22';
                $dpp = $item[31] - (11/111 *  $item[31] );
                $kode_akun= 411122;
            }elseif ($item[27] === 'Pajak Penghasilan Ps 23') {
                # code...
                $jenis_pajak = 'PPH 23';
                $dpp = 100/2 * $item[28];
                $kode_akun= 411124;
            }elseif ($item[27] === 'Pajak Pertambahan Nilai') {
                # code...
                $jenis_pajak = 'PPN';
                $dpp = 100/111 * $item[31];
                $kode_akun= 411211;
                

            }else{
                $jenis_pajak = $item[27];
                $dpp = '';
                $kode_akun= '';
            }
            
            
             return [
                "tbp_kwt" =>$item[22],
                "nilai_belanja"=>$item[31],
                "uraian_belanja"=>$item[25],
                "dpp"=> number_format((float)$dpp, 2, '.', '') ,
                "kode_akun"=>$kode_akun,
                "jenis_pajak"=>$jenis_pajak,
                "jumlah_pajak"=>$item[28],
                "npwp"=>"",
                "nama_skpd"=>$item[1],
                "ntpn"=>$item[30],
             ];
        });
      
        return $result;
        // {
        //     "Kode_SKPD": "5.02.0.00.0.00.01.0000",
        //     "Nama_SKPD": "BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH",
        //     "Kode_Sub_SKPD": "5.02.0.00.0.00.01.0000",
        //     "Nama_Sub_SKPD": "BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH",
        //     "Kode_Urusan": "5",
        //     "Nama_Urusan": "UNSUR PENUNJANG URUSAN PEMERINTAHAN",
        //     "Kode_Bidang_Urusan": "5.02",
        //     "Nama_Bidang_Urusan": "KEUANGAN",
        //     "Kode_Program": "5.02.01",
        //     "Nama_Program": "PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH PROVINSI",
        //     "Kode_Kegiatan": "5.02.01.1.01",
        //     "Nama_Kegiatan": "Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah",
        //     "Kode_Sub_Kegiatan": "5.02.01.1.01.01",
        //     "Nama_Sub_Kegiatan": "Penyusunan Dokumen Perencanaan Perangkat Daerah",
        //     "Kode_Rekening": "5.1.02.02.01.0071",
        //     "Nama_Rekening": "Belanja Lembur",
        //     "Nomor_SPD": "08.00/01.0/000001/5.02.0.00.0.00.01.0000/P.03/6/2023",
        //     "Periode_SPD": "sm1",
        //     "Nilai_Detail_SPD": "10695000",
        //     "Sub_Tahap_SPD": "APBD Pergeseran III",
        //     "Dokumen": "TBP",
        //     "Jenis": "UP",
        //     "Nomor_Dokumen": "08.00/06.0/000628/UP/5.02.0.00.0.00.01.0000/P.03/6/2023",
        //     "Tanggal_Dokumen": "2023-06-13",
        //     "Bulan_Dok": "Jun",
        //     "Keterangan_Dok": "Pemby Belanja Lembur Sekrtariat tgl 30 Mei sd 3 Juni 2023, SPT No. : 800/216/Sekrt/BPKAD/2023",
        //     "Kategori": "pajak",
        //     "Jenis_Potongan/Pajak": "PPH 21",
        //     "Nilai_Potongan/Pajak": "317000",
        //     "ID_Billing": "027702839560119",
        //     "NTPN": "42C9B7454SS1QHTN",
        //     "Nilai_Belanja_Rek_Bruto": "4773000",
        //     "Nama_Rekening_Penerima": "Desti Elni",
        //     "Nomor_Rekening_Penerima": "21010210051021",
        //     "Nama_Bank": "Bank Nagari",
        //     "User_Dok": "BPP.BPKAD",
        //     "Pegawai_Dok": "HENDRIZAL",
        //     "Nomor_SPP": "08.00/02.0/000002/GU/5.02.0.00.0.00.01.0000/P.02/5/2023",
        //     "Tanggal_SPP": "2023-05-12",
        //     "Nomor_SPM": "08.00/03.0/000002/GU/5.02.0.00.0.00.01.0000/P.02/5/2023",
        //     "Tanggal_SPM": "2023-05-12",
        //     "Nomor_SP2D": "08.00/04.0/000002/GU/5.02.0.00.0.00.01.0000/P.02/5/2023",
        //     "Tanggal_SP2D": "2023-05-12"
        //     },
        return collect($result['UP, GU, TU, dan LS'])->where("Bulan_Dok","Jun")
        ->where('Jenis',"UP")
        ->where('Kategori',"pajak")->map(function($item){
            return [
                "tbp_kwt"=>$item['Nomor_Dokumen'],
                "nama_skpd"=>$item['Nama_SKPD'],
                "nilai_belanja"=>$item['Nilai_Belanja_Rek_Bruto'],
                "uraian_belanja"=>$item['Keterangan_Dok'],
                "dpp"=>"",
                "kode_akun"=>"",
                "jenis_pajak"=>"",
                "jumlah_pajak"=>"",
                "npwp"=>"",
                "ntpn"=>""

            ];
        })
        ->values();


        //-------------------
        //jika tidak menggunakan nama sheet
        // $phoneNumbersData= [];
        // foreach ($data[0] as $key => $value) {
        //     $phoneNumbersData[] = [
        //         'kode_skpd'=>$value[0],
        //         'nama_skpd'=>$value[1]
        //     ];
        // }
        // $phoneNumbersData = collect($data[0])->slice(1)->map(function ($value) {
        //     return [
        //         'kode_skpd' => $value[0],
        //         'nama_skpd' => $value[1],
        //         'tanggal' => $value[2]
        //     ];
        // });
        // return $phoneNumbersData->values();
    
    }
    public function loginSipd(){
        
        // URL halaman yang berisi form
        $url = 'https://sipd.kemendagri.go.id/siap/';

        // Lakukan permintaan GET ke halaman yang berisi form

        $response = Http::withoutVerifying()
        
            ->withOptions(["verify"=>false])
            ->get($url);

        // Buat objek Crawler untuk memparsing HTML respons
        $crawler = new Crawler($response->body());

        // Temukan nilai _token dalam form menggunakan selektor CSS atau XPath
        $token = $crawler->filter('input[name="_token"]')->attr('value');



        $url = 'https://sipd.kemendagri.go.id/siap/login';

        // Membuat instance CookieJar
        $cookieJar = new CookieJar();
        //untuk generate token info username password jalankan perintah artisan login:sipd
        $token =  Storage::get('token.txt');
        $decoded = TokenHelper::decodeToken($token);
        // Melakukan permintaan login
        $response = Http::withOptions(['cookies' => $cookieJar])
        ->withOptions(["verify"=>false])
        ->post($url,[
            '_token'=> $token,
            'userName' => $decoded['username'],
            'password' =>  $decoded['password'],
            'tahunanggaran' => $decoded['tahun'],
            'idDaerah'=>$decoded['idDaerah'],
            ]
        );
        // Mendapatkan cookie dari CookieJar
        $cookies = $cookieJar->toArray();
        // Menyimpan cookie dalam file menggunakan Laravel Storage
        Storage::put('cookies.txt', serialize($cookies));
        // return $this->getDataSp2dVer($request);
        return true;
    }

    public function cekLogin(){
    
            $cookieFileContents = Storage::get('cookies.txt'); 
            if (!$cookieFileContents) {
                # code...
                // return 'file cookies tidak ada';
                return  $this->loginSipd();
                // $this->getDataSp2dVer(); 
            }else{
                $cookie = unserialize($cookieFileContents);
            
                $cookieName = $cookie[0]['Name'];
                $expires = $cookie[0]['Expires'];
                if ($expires && time() > $expires) {
                    //  return 'cookie expire';
                    return  $this->loginSipd();
                
                    
                }else {
                    # code...
                    return  true;
                } 
            }
    }
    public function gate(Request $request){
        $cookieFileContents = Storage::get('cookies.txt'); 
        if (!$cookieFileContents) {
            # code...
            // return 'file cookies tidak ada';
            if ($this->cekLogin()) {
                return $this->getDataSp2dVer($request);
            }
            
        }else{
            $cookie = unserialize($cookieFileContents);
            $cookieName = $cookie[0]['Name'];
            $expires = $cookie[0]['Expires'];
            if ($expires && time() > $expires) {
                // return 'cookie expire';
                if ($this->cekLogin()) {
                    return $this->getDataSp2dVer($request);
                }

            }else {
                # code...
            
                return  $this->getDataSp2dVer($request);
            } 
        }
    }

    public function getDataSp2dVer(Request $request){
        
        // Membuat instance CookieJar
        $cookieJar = new CookieJar();

        // Mendapatkan isi file cookies.txt
        $cookieFileContents = Storage::get('cookies.txt');
       
        // Melakukan unserialize pada isi file
        $cookies = unserialize($cookieFileContents);

        // Memasukkan cookie ke dalam CookieJar
        foreach ($cookies as $cookie) {

                $setCookie = new SetCookie($cookie);
                $cookieJar->setCookie($setCookie);

        }
        if($request->has('page')){
            // URL halaman yang membutuhkan otorisasi
            $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page='.$request->page.'&per_page=10&verifikasiSp2d=1';

        }else{
            // URL halaman yang membutuhkan otorisasi
            $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?verifikasiSp2d=1';

        }
          
       // Melakukan permintaan GET ke halaman yang membutuhkan otorisasi
        $response = Http::withOptions(['cookies' => $cookieJar])
        ->withOptions(["verify"=>false])
        ->get($url);
            // return $response->status();
          // Menampilkan respons
            $data =  $response->object();
            // return $data;
            $currentPage = $data->current_page; // Nomor halaman saat ini
            $totalPages = $data->last_page; // Jumlah total halaman
          
            $halaman = collect();
            $puluhan = floor($currentPage / 10) * 10;
            
            $arrRange = range($puluhan + 1, $puluhan+10);
    
            foreach ($arrRange as $num) {
               
                if($num == $currentPage){
                    $aktif = false;
                }else{
                    $aktif = true;
                }
                $halaman->push([
                    'title'=>$num,
                    'aktif'=>$aktif,
                    'link'=>url('/').'/get?page='.$num
                    ]
                );
                 if($num == $totalPages){
                    break;
                }
            }

           
            $new_base_url = url('/').'/get';
            
            // Memisahkan base URL dan parameter dari URL asli
            $last_page_url = parse_url($data->last_page_url);
            $parametersLastPage = isset($last_page_url['query']) ? $last_page_url['query'] : '';

            $first_page_url = parse_url($data->first_page_url);
            $parametersFirstPage = isset($first_page_url['query']) ? $first_page_url['query'] : '';

            $prev_page_url = $data->prev_page_url ? parse_url($data->prev_page_url) : null;
            
            if ($prev_page_url) {
                # code...
                $parametersPrevPage = isset($prev_page_url['query']) ? $prev_page_url['query'] : '';
                $new_prev_page = $new_base_url;
                if (!empty($parametersPrevPage)) {
                    $new_prev_page .= '?' . $parametersPrevPage;
                }
            }else{
                $new_prev_page= null;
            }
            
            $next_page_url = $data->next_page_url ? parse_url($data->next_page_url) : null;
            
            if ($next_page_url) {
                # code...
                $parametersNextPage = isset($next_page_url['query']) ? $next_page_url['query'] : '';
                $new_next_page = $new_base_url;
                if (!empty($parametersNextPage)) {
                    $new_next_page .= '?' . $parametersNextPage;
                }
            }else{
                $new_next_page= null;
            }

            // Membangun URL baru dengan base URL yang baru dan parameter yang sama
            $new_last_page = $new_base_url;
            if (!empty($parametersLastPage)) {
                $new_last_page .= '?' . $parametersLastPage;
            }
        
            $new_first_page = $new_base_url;
            if (!empty($parametersFirstPage)) {
                $new_first_page .= '?' . $parametersFirstPage;
            }
        
            // Menambahkan key baru "halaman" ke array data
            
            $collectionHalaman = collect(['halaman' => $halaman]);
            $data = collect($data);
            $data['last_page_url'] = $new_last_page;
            $data['first_page_url'] = $new_first_page;
            $data['path']=$new_base_url;
            $data['prev_page_url']=$new_prev_page;
            $data['next_page_url']=$new_next_page;
            
            $merged = $data->merge($collectionHalaman);


            return $merged;
    }
    public function getDataSp2dVerifikasi(Request $request){
        
        if ($this->cekLogin()) {
            # code...
            
        // Membuat instance CookieJar
        $cookieJar = new CookieJar();

        // Mendapatkan isi file cookies.txt
        $cookieFileContents = Storage::get('cookies.txt');
       
        // Melakukan unserialize pada isi file
        $cookies = unserialize($cookieFileContents);

        // Memasukkan cookie ke dalam CookieJar
        foreach ($cookies as $cookie) {
                $setCookie = new SetCookie($cookie);
                $cookieJar->setCookie($setCookie);
        }
        if($request->has('page') && $request->has('search') ){
            $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page='.$request->page.'&per_page=100&search='.$request->search.'&verifikasiSp2d=1';
        }
        elseif ($request->has('page')){
            // URL halaman yang membutuhkan otorisasi
            $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page='.$request->page.'&per_page=100&verifikasiSp2d=1';

        }else{
            // URL halaman yang membutuhkan otorisasi
            // $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?verifikasiSp2d=1';
            $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page=1&per_page=100&verifikasiSp2d=1';
        }
        
    

       // Melakukan permintaan GET ke halaman yang membutuhkan otorisasi
        $response = Http::withOptions(['cookies' => $cookieJar])
        ->withOptions(["verify"=>false])
        ->get($url);
            // return $response->status();
            // Menampilkan respons
                if($response->ok()){
                    
                    $data =  $response->object();
                    $currentPage = $data->current_page; // Nomor halaman saat ini
                    $totalPages = $data->last_page; // Jumlah total halaman
                    $halaman = collect();
                    $puluhan = floor($currentPage / 10) * 10;
                    
                    $arrRange = range($puluhan + 1, $puluhan+10);
            
                    foreach ($arrRange as $num) {
                    
                        if($num == $currentPage){
                            $aktif = false;
                        }else{
                            $aktif = true;
                        }
                        $halaman->push([
                            'title'=>$num,
                            'aktif'=>$aktif,
                            'link'=>url('/').'/api/list-sp2d-verifikasi?page='.$num
                            ]
                        );
                        if($num == $totalPages){
                            break;
                        }
                    }

                
                    $new_base_url = url('/').'/api/list-sp2d-verifikasi';
                    
                    // Memisahkan base URL dan parameter dari URL asli
                    $last_page_url = parse_url($data->last_page_url);
                    $parametersLastPage = isset($last_page_url['query']) ? $last_page_url['query'] : '';

                    $first_page_url = parse_url($data->first_page_url);
                    $parametersFirstPage = isset($first_page_url['query']) ? $first_page_url['query'] : '';

                    $prev_page_url = $data->prev_page_url ? parse_url($data->prev_page_url) : null;
                    
                    if ($prev_page_url) {
                        # code...
                        $parametersPrevPage = isset($prev_page_url['query']) ? $prev_page_url['query'] : '';
                        $new_prev_page = $new_base_url;
                        if (!empty($parametersPrevPage)) {
                            $new_prev_page .= '?' . $parametersPrevPage;
                        }
                    }else{
                        $new_prev_page= null;
                    }
                    
                    $next_page_url = $data->next_page_url ? parse_url($data->next_page_url) : null;
                    
                    if ($next_page_url) {
                        # code...
                        $parametersNextPage = isset($next_page_url['query']) ? $next_page_url['query'] : '';
                        $new_next_page = $new_base_url;
                        if (!empty($parametersNextPage)) {
                            $new_next_page .= '?' . $parametersNextPage;
                        }
                    }else{
                        $new_next_page= null;
                    }

                    // Membangun URL baru dengan base URL yang baru dan parameter yang sama
                    $new_last_page = $new_base_url;
                    if (!empty($parametersLastPage)) {
                        $new_last_page .= '?' . $parametersLastPage;
                    }
                
                    $new_first_page = $new_base_url;
                    if (!empty($parametersFirstPage)) {
                        $new_first_page .= '?' . $parametersFirstPage;
                    }
                
                    // Menambahkan key baru "halaman" ke array data
                    
                    $collectionHalaman = collect(['halaman' => $halaman]);
                    $data = collect($data);
                    $data['last_page_url'] = $new_last_page;
                    $data['first_page_url'] = $new_first_page;
                    $data['path']=$new_base_url;
                    $data['prev_page_url']=$new_prev_page;
                    $data['next_page_url']=$new_next_page;
                    
                    $merged = $data->merge($collectionHalaman);


                    return $merged;
                    //     $totalData = $respon->total;
                    //     $totalFiltered = $totalData;
        
                    
                    //     $json_data = array(
                    //         // "draw" => intval($request->input('draw')),
                    //         "recordsTotal" => intval($totalData),
                    //         "recordsFiltered" => intval($totalFiltered),
                    //         "data" => $respon->data
                    //     );
                    // return $json_data;       
                }else{
                    return $response;
                }
        
        }else{
            return 'terjadi kesalahan';
        }

    }
    public function getDataSp2dHistory(Request $request){
    
        if ($this->cekLogin()) {
            # code...
            //history transaksi
        
            // Membuat instance CookieJar
            $cookieJar = new CookieJar();

            // Mendapatkan isi file cookies.txt
            $cookieFileContents = Storage::get('cookies.txt');
            
            // Melakukan unserialize pada isi file
            $cookies = unserialize($cookieFileContents);

            // Memasukkan cookie ke dalam CookieJar
            foreach ($cookies as $cookie) {

                    $setCookie = new SetCookie($cookie);
                    $cookieJar->setCookie($setCookie);

            }
            if($request->has('page')){
                // URL halaman yang membutuhkan otorisasi
                $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/histori-transaksi?page='.$request->page;

            }else{
                // URL halaman yang membutuhkan otorisasi
                $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/histori-transaksi';

            }
            

            
            if($request->bulantahun){
                $parts = explode('-', $request->bulantahun); //12-2023

                $bulan = $parts[0]; // "12"
                $tahun = $parts[1]; // "2023"
            }else{
                $bulan = '';
                $tahun = '';
            }

            // Melakukan permintaan GET ke halaman yang membutuhkan otorisasi
            $response = Http::withOptions(['cookies' => $cookieJar])
            ->withOptions(["verify"=>false])
            ->post($url,[
            
                "page"=>$request->page,
                "per_page"=>10,
                "bulan_gaji"=>$bulan,
                "tahun_gaji"=>$tahun,
                "jenis_gaji"=>1,
                "id_skpd"=>$request->id_skpd,
                "jenis_sp2d"=>"LS|NONGAJI",
                "status_transaksi"=>null,
                "search"=>$request->input('search.value')

                // "page"=>1,
                // "per_page"=>10,
                // "bulan_gaji"=>5,
                // "tahun_gaji"=>2023,
                // "jenis_gaji"=>1,
                // "id_skpd"=>2594,
                // "jenis_sp2d"=>"LS|NONGAJI",
                // "status_transaksi"=>null,
                // "search"=>null
                ]);

        
            // Menampilkan respons
                if($response->ok()){
                    $respon =  $response->object();
            
                
                
                        $totalData = $respon->data->total;
                        $totalFiltered = $totalData;
        
                    
                        $json_data = array(
                            "draw" => intval($request->input('draw')),
                            "recordsTotal" => intval($totalData),
                            "recordsFiltered" => intval($totalFiltered),
                            "data" => $respon->data->data
                        );
                
                    return $json_data;       
                }
        
                // $new_base_url = url('/').'/api/history-sp2d';
            //     $currentPage = $data->current_page; // Nomor halaman saat ini
            //     $totalPages = $data->last_page; // Jumlah total halaman

            // $halaman = collect();
            // $puluhan = floor($currentPage / 10) * 10;
            
            // $arrRange = range($puluhan + 1, $puluhan+10);
            
            
            // // Memisahkan base URL dan parameter dari URL asli
            // $last_page_url = parse_url($data->last_page_url);
            // $parametersLastPage = isset($last_page_url['query']) ? $last_page_url['query'] : '';

            // $first_page_url = parse_url($data->first_page_url);
            // $parametersFirstPage = isset($first_page_url['query']) ? $first_page_url['query'] : '';

            // $prev_page_url = $data->prev_page_url ? parse_url($data->prev_page_url) : null;
            
            // if ($prev_page_url) {
            //     # code...
            //     $parametersPrevPage = isset($prev_page_url['query']) ? $prev_page_url['query'] : '';
            //     $new_prev_page = $new_base_url;
            //     if (!empty($parametersPrevPage)) {
            //         $new_prev_page .= '?' . $parametersPrevPage;
            //     }
            // }else{
            //     $new_prev_page= null;
            // }
            
            // $next_page_url = $data->next_page_url ? parse_url($data->next_page_url) : null;
            
            // if ($next_page_url) {
            //     # code...
            //     $parametersNextPage = isset($next_page_url['query']) ? $next_page_url['query'] : '';
            //     $new_next_page = $new_base_url;
            //     if (!empty($parametersNextPage)) {
            //         $new_next_page .= '?' . $parametersNextPage;
            //     }
            // }else{
            //     $new_next_page= null;
            // }

            // // Membangun URL baru dengan base URL yang baru dan parameter yang sama
            // $new_last_page = $new_base_url;
            // if (!empty($parametersLastPage)) {
            //     $new_last_page .= '?' . $parametersLastPage;
            // }
        
            // $new_first_page = $new_base_url;
            // if (!empty($parametersFirstPage)) {
            //     $new_first_page .= '?' . $parametersFirstPage;
            // }   
                
            // $halaman->push([
            //     'title'=>'First',
            //     'aktif'=>$data->first_page_url?true:false,
            //     'link'=>$new_first_page
            //     ]
            // );
            // $halaman->push([
            //     'title'=>'Prev',
            //     'aktif'=>$data->prev_page_url?true:false,
            //     'link'=>$new_prev_page
            //     ]
            // );

            // foreach ($arrRange as $num) {
            
            //     if($num == $currentPage){
            //         $aktif = false;
            //     }else{
            //         $aktif = true;
            //     }

            //     $halaman->push([
            //         'title'=>$num,
            //         'aktif'=>$aktif,
            //         'link'=>url('/').'/api/history-sp2d?page='.$num
            //         ]
            //     );
            //      if($num == $totalPages){
            //         break;
            //     }
            // }
            // $halaman->push([
            //     'title'=>'Next',
            //     'aktif'=>$data->next_page_url?true:false,
            //     'link'=>$new_next_page
            //     ]
            // );
            // $halaman->push([
            //     'title'=>'Last',
            //     'aktif'=>$data->last_page_url?true:false,
            //     'link'=>$new_last_page
            //     ]
            // );

        
            
        
            // // Menambahkan key baru "halaman" ke array data
            
            // $collectionHalaman = collect(['halaman' => $halaman]);
            // $data = collect($data);
            // $data['last_page_url'] = $new_last_page;
            // $data['first_page_url'] = $new_first_page;
            // $data['path']=$new_base_url;
            // $data['prev_page_url']=$new_prev_page;
            // $data['next_page_url']=$new_next_page;
            
            // $merged = $data->merge($collectionHalaman);
            
            
            // return $merged;
        

        }else{
            return 'terjadi kesalahan';
        }

    
    }

    public function dataSkpd(){
        $json = '[
            {
                "label": "1.01.0.00.0.00.01.0000 - DINAS PENDIDIKAN",
                "value": "2559"
            },
            {
                "label": "1.02.0.00.0.00.01.0000 - DINAS KESEHATAN",
                "value": "2560"
            },
            {
                "label": "1.02.0.00.0.00.02.0000 - RUMAH SAKIT UMUM DAERAH Dr. ACHMAD MOCHTAR BUKITTINGI",
                "value": "2561"
            },
            {
                "label": "1.02.0.00.0.00.03.0000 - RUMAH SAKIT JIWA Prof. HB. SAANIN",
                "value": "2562"
            },
            {
                "label": "1.02.0.00.0.00.04.0000 - RUMAH SAKIT UMUM DAERAH MOHAMMAD NATSIR",
                "value": "2563"
            },
            {
                "label": "1.02.0.00.0.00.05.0000 - RUMAH SAKIT UMUM DAERAH PARIAMAN",
                "value": "2564"
            },
            {
                "label": "1.03.0.00.0.00.01.0000 - DINAS BINA MARGA, CIPTA KARYA DAN TATA RUANG",
                "value": "2565"
            },
            {
                "label": "1.03.0.00.0.00.02.0000 - DINAS SUMBER DAYA AIR DAN BINA KONSTRUKSI",
                "value": "2588"
            },
            {
                "label": "1.04.2.10.0.00.01.0000 - DINAS PERUMAHAN RAKYAT, KAWASAN PERMUKIMAN DAN PERTANAHAN",
                "value": "2591"
            },
            {
                "label": "1.05.0.00.0.00.01.0000 - SATUAN POLISI PAMONG PRAJA",
                "value": "2592"
            },
            {
                "label": "1.05.0.00.0.00.02.0000 - BADAN PENANGGULANGAN BENCANA DAERAH",
                "value": "2593"
            },
            {
                "label": "1.06.0.00.0.00.01.0000 - DINAS SOSIAL",
                "value": "2594"
            },
            {
                "label": "2.07.3.32.0.00.01.0000 - DINAS TENAGA KERJA DAN TRANSMIGRASI",
                "value": "2603"
            },
            {
                "label": "2.08.2.14.0.00.01.0000 - DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK, PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA",
                "value": "2607"
            },
            {
                "label": "2.09.0.00.0.00.01.0000 - DINAS PANGAN",
                "value": "2609"
            },
            {
                "label": "2.12.0.00.0.00.01.0000 - DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL",
                "value": "2615"
            },
            {
                "label": "2.13.0.00.0.00.01.0000 - DINAS PEMBERDAYAAN MASYARAKAT DAN DESA",
                "value": "2616"
            },
            {
                "label": "2.15.0.00.0.00.01.0000 - DINAS PERHUBUNGAN",
                "value": "2617"
            },
            {
                "label": "2.16.2.20.2.21.01.0000 - DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK",
                "value": "2618"
            },
            {
                "label": "2.17.0.00.0.00.01.0000 - DINAS KOPERASI, USAHA KECIL DAN MENENGAH",
                "value": "2619"
            },
            {
                "label": "2.18.0.00.0.00.01.0000 - DINAS PENANAMAN MODAL PROVINSI DAN PELAYANAN TERPADU SATU PINTU",
                "value": "2621"
            },
            {
                "label": "2.19.0.00.0.00.01.0000 - DINAS PEMUDA DAN OLAHRAGA",
                "value": "2622"
            },
            {
                "label": "2.22.0.00.0.00.01.0000 - DINAS KEBUDAYAAN",
                "value": "2624"
            },
            {
                "label": "2.23.2.24.0.00.01.0000 - DINAS KEARSIPAN DAN PERPUSTAKAAN",
                "value": "2627"
            },
            {
                "label": "3.25.0.00.0.00.01.0000 - DINAS KELAUTAN DAN PERIKANAN",
                "value": "2628"
            },
            {
                "label": "3.26.0.00.0.00.01.0000 - DINAS PARIWISATA",
                "value": "2635"
            },
            {
                "label": "3.27.0.00.0.00.01.0000 - DINAS PERKEBUNAN, TANAMAN PANGAN DAN HOLTIKULTURA",
                "value": "2636"
            },
            {
                "label": "3.27.0.00.0.00.02.0000 - DINAS PETERNAKAN DAN KESEHATAN HEWAN",
                "value": "2643"
            },
            {
                "label": "3.28.0.00.0.00.01.0000 - DINAS KEHUTANAN",
                "value": "2649"
            },
            {
                "label": "3.29.0.00.0.00.01.0000 - DINAS ENERGI DAN SUMBER DAYA MINERAL",
                "value": "2661"
            },
            {
                "label": "3.30.3.31.0.00.01.0000 - DINAS PERINDUSTRIAN DAN PERDAGANGAN",
                "value": "2662"
            },
            {
                "label": "4.01.0.00.0.00.01.0000 - SEKRETARIAT DAERAH",
                "value": "2666"
            },
            {
                "label": "4.02.0.00.0.00.01.0000 - SEKRETARIAT DPRD",
                "value": "2676"
            },
            {
                "label": "5.01.0.00.0.00.01.0000 - BADAN PERENCANAAN PEMBANGUNAN DAERAH",
                "value": "2677"
            },
            {
                "label": "5.02.0.00.0.00.01.0000 - BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH",
                "value": "2679"
            },
            {
                "label": "5.02.0.00.0.00.02.0000 - BADAN PENDAPATAN DAERAH",
                "value": "2678"
            },
            {
                "label": "5.03.0.00.0.00.01.0000 - BADAN KEPEGAWAIAN DAERAH",
                "value": "2680"
            },
            {
                "label": "5.04.0.00.0.00.01.0000 - BADAN PENGEMBANGAN SUMBER DAYA MANUSIA",
                "value": "2681"
            },
            {
                "label": "5.05.0.00.0.00.01.0000 - BADAN PENELITIAN DAN PENGEMBANGAN",
                "value": "2682"
            },
            {
                "label": "5.07.0.00.0.00.01.0000 - BADAN PENGHUBUNG",
                "value": "2683"
            },
            {
                "label": "6.01.0.00.0.00.01.0000 - INSPEKTORAT DAERAH PROVINSI",
                "value": "2684"
            },
            {
                "label": "8.01.0.00.0.00.01.0000 - BADAN KESATUAN BANGSA DAN POLITIK",
                "value": "2685"
            }
        ]';
        $phpArray = json_decode($json, true);
        return $phpArray;
        $dataSkpd = collect(
            [
            [
                "label"=>"1.01.0.00.0.00.01.0000 - DINAS PENDIDIKAN",
                "value"=> 2559
            ],
            [
                "label"=>"1.02.0.00.0.00.01.0000 - DINAS KESEHATAN",
                "value"=> 2560
            ]
            ]
        );
        return $dataSkpd;
    }
}

