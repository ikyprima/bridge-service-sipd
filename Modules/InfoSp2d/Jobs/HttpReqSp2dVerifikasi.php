<?php

namespace Modules\InfoSp2d\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Facades\Storage;
use Modules\InfoSp2d\Entities\MInfoSp2d;
use Modules\InfoSp2d\Entities\MhalamanImport;
use Modules\InfoSp2d\Entities\MKesalahanImportData;

use DB;
class HttpReqSp2dVerifikasi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $halaman;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $halaman)
    {
        $this->halaman = $halaman;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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

        $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page='.$this->halaman.'&per_page=10&verifikasiSp2d=1';
        
        try {
            $response = Http::withOptions(['cookies' => $cookieJar])
            ->withOptions(["verify"=>false])
            ->get($url);
            if($response->ok()){
                $data = $response->object();
                if ($data) {
                    $data = collect($data->data)->map(function($item){
                        return [
                            'kodeSkpd'=> $item->kodeSkpd,
                            'namaSkpd'=>$item->namaSkpd,
                            'idSp2d'=>$item->idSp2d,
                            'noSp2d' =>$item->nomorSp2d,
                            'tahunSp2d' =>$item->tahunSp2d,
                            'keteranganSp2d' =>$item->keteranganSp2d,
                            'tanggalSp2d'=>$item->tanggalSp2d,
                            'jenisSp2d'=>$item->jenisSp2d,
                            'nilaiSp2d'=>$item->nilaiSp2d,
                            'verifikasiSp2d'=>$item->verifikasiSp2d,
                            'is_nilai_sp2d_valid'=>$item->is_nilai_sp2d_valid,
                            'nomor_halaman'=>$this->halaman
                        ];
                    });
                    // MInfoSp2d::where('nomor_halaman',$this->halaman )
                    // ->where('tahunSp2d',$data[0]['tahunSp2d'])
                    // ->delete();
                    // DB::table('tb_info_sp2d')->insert($data->toArray());

                    foreach ($data as $key => $item) {
                        # code...
                        MInfoSp2d::updateOrCreate(
                            [
                                'idSp2d' =>  $item['idSp2d'],
                                'noSp2d' =>$item['noSp2d']
                            ],
                            [
                                'kodeSkpd'=> $item['kodeSkpd'],
                                'namaSkpd'=>$item['namaSkpd'],
                                'tahunSp2d' =>$item['tahunSp2d'],
                                'keteranganSp2d' =>$item['keteranganSp2d'],
                                'tanggalSp2d'=>$item['tanggalSp2d'],
                                'jenisSp2d'=>$item['jenisSp2d'],
                                'nilaiSp2d'=>$item['nilaiSp2d'],
                                'verifikasiSp2d'=>$item['verifikasiSp2d'],
                                'is_nilai_sp2d_valid'=>$item['is_nilai_sp2d_valid'],
                                'nomor_halaman'=>$this->halaman
                            ]
                        );
                    }
                    MhalamanImport::updateOrCreate(
                        [
                            'id_jenis_data_source' => 1,
                            'tahun' => 2023
                        ],
                        [
                            'halaman_terakhir'=> $this->halaman
                        ]
                    );

                }else{
                    $error = 'tidak ada return object atau redirect ke halaman login';
                    MKesalahanImportData::create(
                        [
                            'id_jenis_data_source'=>1,
                            'halaman_gagal'=>$this->halaman,
                            'nama_kesalahan_error'=> $error,
                            'url'=>$url
                        ]
                    );
                }
            }else{
                $error =  'request ke http tidak ok (200), terjadi kesalahan dengan error kode ('.$response->status().')';
                MKesalahanImportData::create(
                        [
                            'id_jenis_data_source'=>1,
                            'halaman_gagal'=>$this->halaman,
                            'nama_kesalahan_error'=> $error,
                            'url'=>$url
                        ]
                );
                
            }
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();
            MKesalahanImportData::create(
                [
                    'id_jenis_data_source'=>1,
                    'halaman_gagal'=>$this->halaman,
                    'nama_kesalahan_error'=> $error,
                    'url'=>$url
                ]
            );
        }
        
    }
}
