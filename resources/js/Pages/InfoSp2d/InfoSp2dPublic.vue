<script setup>
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
</script>

<template>
    <Head>
        <title>INFORMASI SP2D</title>
        <meta name="description" content="Halaman Informasi SP2D Yang Sudah Terbit">
    </Head>
    <section class="relative  w-full h-full py-20 min-h-screen ">
        <div class="absolute  top-0 w-full h-full bg-emerald-800 bg-no-repeat bg-center bg-fixed "
            :style="`background-image: linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73)),url('${registerBg2}');`">
        </div>
        
        <div class="container mx-auto px-4 h-full opacity-90">

            <div class="flex content-center justify-center h-full ">
                <div class="w-full lg:w-full ">
                    <div class="grid grid-cols-1 ">
                        <div class="text-lg font-bold">

                        </div>
                        <div class=" text-white rounded-md ">

                            <label for="search"
                                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cari</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="search" v-model="search" v-on:keyup.enter="cari"
                                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="cari nomor sp2d / uraian / nama skpd" required>
                                <button type="button" id="carisp2d" @click="cari"
                                    class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">CARI</button>
                            </div>

                        </div>

                    </div>
                    <div
                        class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg  mt-2 bg-white py-2 ">
                        <div class="mt-2 overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead class="">
                                    <tr class="text-base font-bold text-left bg-gray-50">
                                        <th class="px-4 py-3 border-b-2 border-blue-500">Tanggal</th>
                                        <th class="px-4 py-3 border-b-2 border-blue-500">Nomor SP2d</th>
                                        <th class="px-4 py-3 border-b-2 border-green-500">Uraian</th>
                                        <th class="px-4 py-3 border-b-2 border-red-500 text-center">Jenis</th>
                                        <th class="px-4 py-3 border-b-2 border-red-500 text-right">Nilai</th>
                                        <th class="px-4 py-3 border-b-2 border-green-500">Nama SKPD</th>
                                        <th class="px-4 py-3 border-b-2 border-green-500">Status</th>

                                    </tr>
                                </thead>
                                <tbody class="text-sm font-normal text-gray-700 text-center">
                                    <template v-for="( data, index ) in data.data">

                                        <tr v-if="index % 2 === 0" class="py-10 bg-gray-100 hover:bg-gray-200 font-medium">
                                            <td class="px-4 py-4">
                                                {{ data.tanggalSp2d }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.noSp2d }}
                                            </td>
                                            <td class="px-4 py-4 text-left">
                                                {{ data.keteranganSp2d }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.jenisSp2d }}
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                {{ formatAsRupiah(data.nilaiSp2d) }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.namaSkpd }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <template v-if="data.verifikasiSp2d == 1">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Verifikasi</span>

                                                </template>
                                                <template v-else>
                                                    <span
                                                        class="bg-red-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Belum
                                                        Verifikasi</span>

                                                </template>


                                            </td>

                                        </tr>
                                        <tr v-else class="py-10 bg-white-100 hover:bg-gray-200 font-medium">
                                            <td class="px-4 py-4">
                                                {{ data.tanggalSp2d }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.noSp2d }}
                                            </td>
                                            <td class="px-4 py-4 text-left">
                                                {{ data.keteranganSp2d }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.jenisSp2d }}
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                {{ formatAsRupiah(data.nilaiSp2d) }}
                                            </td>
                                            <td class="px-4 py-4">
                                                {{ data.namaSkpd }}
                                            </td>
                                            <td class="px-4 py-4">
                                                <template v-if="data.verifikasiSp2d == 1">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Verifikasi</span>

                                                </template>
                                                <template v-else>
                                                    <span
                                                        class="bg-red-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Belum
                                                        Verifikasi</span>

                                                </template>


                                            </td>

                                        </tr>

                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="flex flex-col items-center w-full px-4 py-2 space-y-2 text-sm text-gray-500 sm:justify-between sm:space-y-0 sm:flex-row">

                            <div id="fromTo"> <p class="flex">Menampilkan&nbsp;<span class="font-bold">{{ data.from }} </span>&nbsp; sampai &nbsp; <span class="font-bold"> {{ data.to }}</span>&nbsp; dari &nbsp;<span class="font-bold">{{ data.total }}</span>  &nbsp; data</p></div>

                            <div class="flex items-center justify-between space-x-2">
                                <div id="prev"></div>
                                <div class="flex flex-row space-x-1" id="halaman">
                                    <template  v-for="paging in data?data.links:[]" >
                                        <template v-if="paging.active == false && paging.url == null">
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else-if="paging.active == true && paging.url != null">
                                            
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else>

                                            <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white" 
                                            :href="paging.url"><h3 v-html="paging.label"></h3></Link>
                                        
                                        </template>

                                        
                                    </template>
                                </div>
                                <div id="next"></div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</template>

<script>
import registerBg2 from "@/img/logo_sumbar.svg";
import register from "@/img/register_bg_2.png";


export default {
    components: {

    },
    props: {
        data: Object,

    },
    computed: {

    },
    data() {
        return {
            registerBg2,
            register,
            search:null
        };
    },

    methods: {
        formatAsRupiah(amount) {
            return amount.toLocaleString("id-ID", {
                // style: "currency",
                // currency: "IDR",
                minimumFractionDigits: 2,
            });
        },
        cari(){
            router.get('/infosp2d/sp2d-verifikasi',
              {
              search: this.search
            
              },
              { 
                replace: true,
                preserveState: true 
              }
            )
           
        }


    }
};
</script>
