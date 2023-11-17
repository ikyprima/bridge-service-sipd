<?php

namespace Modules\InfoSp2d\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Http\Controllers\sp2d;
use Modules\InfoSp2d\Jobs\HttpReqSp2dVerifikasi;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

use Modules\InfoSp2d\Entities\MhalamanImport;
use Modules\InfoSp2d\Entities\MInfoSp2d;
class InfoSp2dController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('infosp2d::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('infosp2d::create');
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
        return view('infosp2d::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('infosp2d::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
    public function hapusHalaman(Request $request){ 
        MhalamanImport::where([['id_jenis_data_source',1,['tahun',2023]]])->delete(); 
    }
    public function importSp2dVerifikasi(Request $request){ 
        if (app(sp2d::class)->cekLogin()) {

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
            try {

                if($request->has('halaman')){
                    //jalankan job berdasarkan halaman tertentu
                    // $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page=83&per_page=10&verifikasiSp2d=1';
                    // $response = Http::withOptions(['cookies' => $cookieJar])->withOptions(["verify"=>false])
                    // ->get($url);
                    // $data = $response->object();
                    // return $data;
                    HttpReqSp2dVerifikasi::dispatch($request->halaman);     
                }else{
                    $url = 'https://sipd.kemendagri.go.id/siap/data/sp2d/0?page=1&per_page=10&verifikasiSp2d=1';
                    $response = Http::withOptions(['cookies' => $cookieJar])->withOptions(["verify"=>false])
                    ->get($url);
                    if($response->ok()){
                        $data = $response->object();
                            if ($data) {
                                $halaman = MhalamanImport::where([['id_jenis_data_source',1,['tahun',2023]]])->first(); 
                                if ($halaman === null) {
                                // belum ada halaman terakhir
                                    $halamanAwal = 1;
                                    $halamanAkhir = $data->last_page;
                                    //  $halamanAkhir = 15;
                                }else{
                                    $halamanAwal = $halaman->halaman_terakhir;
                                    $halamanAkhir = $data->last_page;
                                    //  $halamanAkhir = 15;
                                }
                                $iteration = 1;
                                
                                for ($i = $halamanAwal; $i <= $halamanAkhir; $i++) {
                                    $delaySeconds = $iteration +=3;
                                    $job = new HttpReqSp2dVerifikasi($i);
                                    $job->delay(now()->addSeconds($delaySeconds));
                                    dispatch($job);
                                    // HttpReqSp2dVerifikasi::dispatch($i)
                                    //  ->delay(now()->addMinutes(1)); 
                                
                                }
                                return 'Queue job sedang berjalan di background, Job dijalankan setelah 1 detik setiap job';
                            }else{
                                return 'tidak ada return object atau redirect ke halaman login';
                            }
                    }else{
                        return 'request ke http tidak ok (200), terjadi kesalahan dengan error kode ('.$response->status().')';
                    }
                }
            
            } catch (\Throwable $th) {
                //throw $th;
                return  $th->getMessage();
            }
        
        
        }else{
            return 'terjadi kesalahan saat login menggunakan cookies';
        }
    
    }
    
    public function listSp2dVerifikasi(Request $request){
        // $this->importSp2dVerifikasi();

        // $MInfoSp2d = MInfoSp2d::where([
        //     [function ($query) use ($request) {
        //         if (($s = $request->search)) {
        //             $query->orWhere('noSp2d', 'LIKE', '%' . $s . '%')
        //                 ->orWhere('keteranganSp2d', 'LIKE', '%' . $s . '%')
        //                 ->orWhere('namaSkpd', 'LIKE', '%' . $s . '%')
        //                 ->get();
        //         }
        //     }]
        // ])->paginate();
            if ($request->has('search')) {
                # code...
                $MInfoSp2d = MInfoSp2d::where('noSp2d', 'like', '%' . $request->search . '%')
                ->orWhere('keteranganSp2d', 'like', '%' . $request->search . '%')
                ->orWhere('namaSkpd', 'like', '%' . $request->search . '%')
                ->orderBy('tanggalSp2d', 'desc')->paginate(10);
                $pagination = $MInfoSp2d->appends ( array (
                    'search' => $request->search
                ) );
                
            }else{
                $MInfoSp2d = MInfoSp2d::where('noSp2d', 'like', '%' . $request->search . '%')
                ->orWhere('keteranganSp2d', 'like', '%' . $request->search . '%')
                ->orWhere('namaSkpd', 'like', '%' . $request->search . '%')
                ->orderBy('tanggalSp2d', 'desc')->paginate(10);
            
            }
        return $MInfoSp2d;
    }
}
