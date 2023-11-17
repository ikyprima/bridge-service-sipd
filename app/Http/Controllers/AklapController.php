<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use TokenHelper;
use Illuminate\Support\Facades\Storage;
class AklapController extends Controller
{

    public function login(Request $request){
        
        $token =  Storage::get('token_aklap.txt');
        $decoded = TokenHelper::decodeToken($token);
        $url = 'https://sipd.kemendagri.go.id/aklap/v1/api/auth/login';
        $response = Http::withOptions(["verify"=>false])->post($url,[
            'username' =>  $decoded['username'],
            'password' =>  $decoded['password'],
            'tahun' => $decoded['tahun'],
            'idDaerah'=>$decoded['idDaerah'],
            ]
        );

        $respon = $response->object();
        $token = $respon->data->token;
        Storage::put('cookies_aklap.txt', serialize($token));
        return true;
    }


    public function cekLogin(){
    
        $cookieFileContents = Storage::get('cookies_aklap.txt'); 
        if (!$cookieFileContents) {
            # code...
            // return 'file cookies tidak ada';
            return  $this->login();
        
        }else{
            return true;
        }
    }

    public function getLra(Request $request){
        
        if ($this->cekLogin()) {
            $cookieFileContents = Storage::get('cookies_aklap.txt'); 
            $cookie = unserialize($cookieFileContents);
            // $searchParam = array(
            //     "idSkpd"=> $request->idSkpd,
            //     "idSkpdUnit"=> $request->idSkpdUnit,
            //     "tanggalFrom"=> $request->tanggalFrom,
            //     "tanggalTo"=> $request->tanggalTo,
            //     "formatFile"=> "preview",
            //     "tahun"=> "2021",
            //     "level"=>$request->level,
            //     "is_induk"=> true,
            //     "skpd" => array(
            //                 "id"=>$request->id,
            //                 "nama_skpd"=>$request->nama_skpd
            //             )
            // );
            if ($request->tipeFile === 'xls') {
                # code...
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "xls",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                    "skpd" => $request->id,
                    "page"=>1,
                    "perpage"=>9999999
        
                );
            }elseif ($request->tipeFile === 'pdf') {
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "pdf",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                    "skpd" => $request->id,
                );
            }else{
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "preview",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                    "skpd" => $request->id,
                   
                );
            }
           
        
            $json = json_encode($searchParam);
            $encodedQueryString = urlencode($json);
    
            $url = 'https://sipd.kemendagri.go.id/aklap/v1/api/report/cetaklra?searchparams='.$encodedQueryString;
            // $url ='https://sipd.kemendagri.go.id/aklap/v1/api/common/list-skpd';
            // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zaXBkLmtlbWVuZGFncmkuZ28uaWRcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2ODYxMjU5NDUsImV4cCI6MjQwNjEyNTk0NSwibmJmIjoxNjg2MTI1OTQ1LCJqdGkiOiI4UEFkQmcxMEJLVnN6YVh3Iiwic3ViIjoxOTA0NTUsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ0YWh1biI6MjAyMywiaWRfZGFlcmFoIjoxODB9.qXtucCisgGVAjbKh9A7jBcCdJ0prFDFPUBkXGp0U0X8";
            $token = $cookie->access_token;
            $response = Http::withToken($token)->withOptions(["verify"=>false])->get($url);
            
            $data = $response->object();
           
            if ( $data == null ){
                // $pdfContent = $response->body();
                // $pdfFileName = 'filetes.xlsx'; 
                // $pdfFilePath = storage_path('app/' . $pdfFileName);
                // file_put_contents($pdfFilePath, $pdfContent);
                return $response->body();
                
            }else{
                
                return $data;
            
            
            }
        }

        
        
    }

    public function reportKonsolidasi(Request $request){
        // return 'ok';
        //parameter setiap request pada sipd aklap

        //aksi = terapkan/preview 
        //klasifikasi = tanpa klasifikasi
        //{"tanggalFrom":"2023-10-01","tanggalTo":"2023-10-11","formatFile":"preview","tahun":"2021","level":null,"previewLaporan":null,"is_combine":"skpd_unit"}
        //------------------------------------------------------------------------------------------------------------------------------------------------------//
        
        //aksi = terapkan/preview
        //klasifikasi = standart akuntansi pemerintah 
        //{"tanggalFrom":"2023-10-01","tanggalTo":"2023-10-11","formatFile":"preview","tahun":"2021","level":7,"previewLaporan":null,"is_combine":"skpd_unit"}
        //----------------------------------------------------------------------------------------------------------------------------------------------------//
        
        //aksi = cetak pdf
        //{"tanggalFrom":"2023-10-01","tanggalTo":"2023-10-11","formatFile":"pdf","tahun":"2021","level":1,"previewLaporan":null,"is_combine":"skpd_unit","skpd":0,"page":1,"perpage":9999999}
        //--------------------------------------------------------------------------------------------------------------------------------------------------//

        //aksi = cetak xls
        //{"tanggalFrom":"2023-10-01","tanggalTo":"2023-10-11","formatFile":"xls","tahun":"2021","level":1,"previewLaporan":null,"is_combine":"skpd_unit","skpd":0,"page":1,"perpage":9999999}

        set_time_limit(6000);
        if ($this->cekLogin()) {
            $cookieFileContents = Storage::get('cookies_aklap.txt'); 
            $cookie = unserialize($cookieFileContents);
           
            if ($request->tipeFile === 'xls') {
                # code...
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "xls",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd_unit", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                    "skpd" => 0,
                    "page"=>1,
                    "perpage"=>9999999
        
                );
            }elseif ($request->tipeFile === 'pdf') {
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "pdf",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd_unit", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                    "skpd" => 0,
                    "page"=>1,
                    "perpage"=>9999999
                );
            }else{
                $searchParam = array(
                    "tanggalFrom"=> $request->tanggalFrom,
                    "tanggalTo"=> $request->tanggalTo,
                    "formatFile"=> "preview",
                    "tahun"=> "2021",
                    "level"=>$request->level,
                    "previewLaporan"=>null,
                    "is_combine"=>"skpd_unit", //skpd= skpd , skpd_mandiri = skpd dan unit konsolidasi , skpd_unit = skpd dan unit
                );
            }
        
        
            $json = json_encode($searchParam);
            $encodedQueryString = urlencode($json);
    
            $url = 'https://sipd.kemendagri.go.id/aklap/v1/api/report/load-report-konsolidasi?searchparams='.$encodedQueryString;
            // $url ='https://sipd.kemendagri.go.id/aklap/v1/api/common/list-skpd';
            // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zaXBkLmtlbWVuZGFncmkuZ28uaWRcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2ODYxMjU5NDUsImV4cCI6MjQwNjEyNTk0NSwibmJmIjoxNjg2MTI1OTQ1LCJqdGkiOiI4UEFkQmcxMEJLVnN6YVh3Iiwic3ViIjoxOTA0NTUsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ0YWh1biI6MjAyMywiaWRfZGFlcmFoIjoxODB9.qXtucCisgGVAjbKh9A7jBcCdJ0prFDFPUBkXGp0U0X8";
            $token = $cookie->access_token;
            $response = Http::withToken($token)->withOptions(["verify"=>false,'timeout' => 6000])->get($url);
            
            $data = $response->object();
           
            if ( $data == null ){
                // $pdfContent = $response->body();
                // $pdfFileName = 'filetes.xlsx'; 
                // $pdfFilePath = storage_path('app/' . $pdfFileName);
                // file_put_contents($pdfFilePath, $pdfContent);
                return $response->body();
                
            }else{
                
                return $data;
            
            
            }
        }

    }

    public function getSkpd(Request $request){
        
        if($this->cekLogin()){
            $cookieFileContents = Storage::get('cookies_aklap.txt'); 
            $cookie = unserialize($cookieFileContents);
            $url = 'https://sipd.kemendagri.go.id/aklap/v1/api/common/skpd/get-skpd-report?keyword='.$request->keyword.'&page='.$request->page;
            $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9zaXBkLmtlbWVuZGFncmkuZ28uaWRcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2ODYxMjU5NDUsImV4cCI6MjQwNjEyNTk0NSwibmJmIjoxNjg2MTI1OTQ1LCJqdGkiOiI4UEFkQmcxMEJLVnN6YVh3Iiwic3ViIjoxOTA0NTUsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJ0YWh1biI6MjAyMywiaWRfZGFlcmFoIjoxODB9.qXtucCisgGVAjbKh9A7jBcCdJ0prFDFPUBkXGp0U0X8";
            // $token = $cookie->access_token;
            $response = Http::withToken($token)->withOptions(["verify"=>false])->get($url);
            
            $data = $response->object(); 
            if ( $data == null ){
            
                return $response->body();
                
            }else{
                
                return $data;
            
            }
        }

    }

}
