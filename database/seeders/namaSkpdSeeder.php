<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\nama_skpd;
class namaSkpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        
            
        $data = [
            [
                'kode_skpd' => '1.01.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PENDIDIKAN',
                'npwp_bendahara'=> '00.119.724.3.205.000'
            ],
            [
                'kode_skpd' => '1.02.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KESEHATAN',
                'npwp_bendahara'=>'00.321.992.0.205.000'
            ],
            [
                'kode_skpd' => '1.02.0.00.0.00.02.0000',
                'nama_skpd' => 'RUMAH SAKIT UMUM DAERAH Dr. ACHMAD MOCHTAR BUKITTINGI',
                'npwp_bendahara'=>'00.139.639.9.202.000'
            ],
            [
                'kode_skpd' => '1.02.0.00.0.00.03.0000',
                'nama_skpd' => 'RUMAH SAKIT JIWA Prof. HB. SAANIN',
                'npwp_bendahara'=>'00.119.725.0.205.000'
            ],
            [
                'kode_skpd' => '1.02.0.00.0.00.04.0000',
                'nama_skpd' => 'RUMAH SAKIT UMUM DAERAH MOHAMMAD NATSIR',
                'npwp_bendahara'=>'95.444.499.8.203.000'
            ],
            [
                'kode_skpd' => '1.02.0.00.0.00.05.0000',
                'nama_skpd' => 'RUMAH SAKIT UMUM DAERAH PARIAMAN',
                'npwp_bendahara'=> '00.119.726.8.201.000'
            ],
            [
                'kode_skpd' => '1.03.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS BINA MARGA, CIPTA KARYA DAN TATA RUANG',
                'npwp_bendahara'=> '00.321.993.8.201.000'
            ],
            [
                'kode_skpd' => '1.03.0.00.0.00.02.0000',
                'nama_skpd' => 'DINAS SUMBER DAYA AIR DAN BINA KONSTRUKSI',
                'npwp_bendahara'=> '00.119.727.6.201.000'
            ],
            [
                'kode_skpd' => '1.04.2.10.0.00.01.0000',
                'nama_skpd' => 'DINAS PERUMAHAN RAKYAT, KAWASAN PERMUKIMAN DAN PERTANAHAN',
                'npwp_bendahara'=>'00.321.994.6.201.000'
            ],
            [
                'kode_skpd' => '1.05.0.00.0.00.01.0000',
                'nama_skpd' => 'SATUAN POLISI PAMONG PRAJA',
                'npwp_bendahara'=> '00.119.728.4.201.000'
            ],
            [
                'kode_skpd' => '2.11.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS LINGKUNGAN HIDUP',
                'npwp_bendahara'=> '00.119.755.7.201.000'
            ],
            [
                'kode_skpd' => '1.05.0.00.0.00.02.0000',
                'nama_skpd' => 'BADAN PENANGGULANGAN BENCANA DAERAH',
                'npwp_bendahara'=>'00.119.690.6.201.000'
            ],
            [
                'kode_skpd' => '1.06.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS SOSIAL',
                'npwp_bendahara'=>'00.321.995.3.201.000'
            ],
            [
                'kode_skpd' => '2.07.3.32.0.00.01.0000',
                'nama_skpd' => 'DINAS TENAGA KERJA DAN TRANSMIGRASI',
                'npwp_bendahara'=>'00.119.753.2.201.000'
            ],
            [
                'kode_skpd' => '2.08.2.14.0.00.01.0000',
                'nama_skpd' => 'DINAS PEMBERDAYAAN PEREMPUAN DAN PERLINDUNGAN ANAK, PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA',
                'npwp_bendahara'=>'00.321.996.1.201.000'
            ],
            [
                'kode_skpd' => '2.09.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PANGAN',
                'npwp_bendahara'=>'00.119.754.0.201.000'
            ],
            [
                'kode_skpd' => '2.12.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL',
                'npwp_bendahara'=>'00.119.756.5.201.000'
            ],
            [
                'kode_skpd' => '2.13.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PEMBERDAYAAN MASYARAKAT DAN DESA',
                'npwp_bendahara'=>'00.321.997.9.201.000'
            ],
            [
                'kode_skpd' => '2.15.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PERHUBUNGAN',
                'npwp_bendahara'=>'00.321.998.7.201.000'
            ],
            [
                'kode_skpd' => '2.16.2.20.2.21.01.0000',
                'nama_skpd' => 'DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK',
                'npwp_bendahara'=>'00.119.757.3.201.000'
            ],
            [
                'kode_skpd' => '2.17.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KOPERASI, USAHA KECIL DAN MENENGAH',
                'npwp_bendahara'=>'00.321.999.5.201.000'
            ],
            [
                'kode_skpd' => '2.18.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PENANAMAN MODAL PROVINSI DAN PELAYANAN TERPADU SATU PINTU',
                'npwp_bendahara'=>'00.322.000.1.201.000'
            ],
            [
                'kode_skpd' => '2.19.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PEMUDA DAN OLAHRAGA',
                'npwp_bendahara'=>'00.119.758.1.201.000'
            ],
            [
                'kode_skpd' => '2.22.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KEBUDAYAAN',
                'npwp_bendahara'=>'00.119.759.9.201.000'
            ],
            [
                'kode_skpd' => '2.23.2.24.0.00.01.0000',
                'nama_skpd' => 'DINAS KEARSIPAN DAN PERPUSTAKAAN',
                'npwp_bendahara'=>'00.322.001.9.201.000'
            ],
            [
                'kode_skpd' => '3.25.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KELAUTAN DAN PERIKANAN',
                'npwp_bendahara'=>'00.119.760.7.205.000'
            ],
            [
                'kode_skpd' => '3.26.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PARIWISATA',
                'npwp_bendahara'=> '00.119.761.5.201.000'
            ],
            [
                'kode_skpd' => '3.27.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS PERKEBUNAN, TANAMAN PANGAN DAN HOLTIKULTURA',
                'npwp_bendahara'=>'00.324.895.2.201.000'
            ],
            [
                'kode_skpd' => '3.27.0.00.0.00.02.0000',
                'nama_skpd' => 'DINAS PETERNAKAN DAN KESEHATAN HEWAN',
                'npwp_bendahara'=>'00.322.002.7.205.000'

            ],
            [
                'kode_skpd' => '3.28.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS KEHUTANAN',
                'npwp_bendahara'=> '00.119.762.3.201.000'
            ],
            [
                'kode_skpd' => '3.29.0.00.0.00.01.0000',
                'nama_skpd' => 'DINAS ENERGI DAN SUMBER DAYA MINERAL',
                'npwp_bendahara'=> '00.322.003.5.201.000'
            ],
            [
                'kode_skpd' => '3.30.3.31.0.00.01.0000',
                'nama_skpd' => 'DINAS PERINDUSTRIAN DAN PERDAGANGAN',
                'npwp_bendahara'=>'00.119.685.6.201.000'
            ],
            [
                'kode_skpd' => '4.01.0.00.0.00.01.0000',
                'nama_skpd' => 'SEKRETARIAT DAERAH',
                'npwp_bendahara'=> '00.119.688.0.201.000'
            ],
            [
                'kode_skpd' => '4.02.0.00.0.00.01.0000',
                'nama_skpd' => 'SEKRETARIAT DPRD',
                'npwp_bendahara'=> '00.321.968.0.201.000'
            ],
            [
                'kode_skpd' => '5.01.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN PERENCANAAN PEMBANGUNAN DAERAH',
                'npwp_bendahara'=> '00.135.500.7.201.000'
            ],
            [
                'kode_skpd' => '5.02.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH',
                'npwp_bendahara'=> '43.031.061.5.201.000'
            ],
            [
                'kode_skpd' => '5.02.0.00.0.00.02.0000',
                'nama_skpd' => 'BADAN PENDAPATAN DAERAH',
                'npwp_bendahara'=>'00.139.635.7.201.000'
            ],
            [
                'kode_skpd' => '5.03.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN KEPEGAWAIAN DAERAH',
                'npwp_bendahara'=> '00.321.966.4.201.000'
            ],
            [
                'kode_skpd' => '5.04.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN PENGEMBANGAN SUMBER DAYA MANUSIA',
                'npwp_bendahara'=>'00.119.686.4.205.000'
            ],
            [
                'kode_skpd' => '5.05.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN PENELITIAN DAN PENGEMBANGAN',
                'npwp_bendahara'=>'00.321.967.2.201.000'
            ],
            [
                'kode_skpd' => '5.07.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN PENGHUBUNG',
                'npwp_bendahara'=> '00.119.687.2.001.000'
            ],
            [
                'kode_skpd' => '6.01.0.00.0.00.01.0000',
                'nama_skpd' => 'INSPEKTORAT DAERAH PROVINSI',
                'npwp_bendahara'=> '00.321.965.6.201.000'
            ],
            [
                'kode_skpd' => '8.01.0.00.0.00.01.0000',
                'nama_skpd' => 'BADAN KESATUAN BANGSA DAN POLITIK',
                'npwp_bendahara'=> '00.119.689.8.201.000'
            ]
        ];
        
        nama_skpd::insert($data);
    }
}
