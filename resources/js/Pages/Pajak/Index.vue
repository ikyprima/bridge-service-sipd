<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import moment from 'moment';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router } from '@inertiajs/vue3'
import NProgress from 'nprogress'
import { ref } from 'vue';

// const month = ref({
//   month: new Date().getMonth(),
//   years: new Date().getFullYear()
// });

</script>


<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekap Pelaporan Pajak</h2>
        </template>
        <div class="container my-10 mx-auto">
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-8 space-y-6">
                <!-- Section: Design Block -->
  <section class="mb-4">
     
    <div
      class="alert alert-dismissible fade show items-center justify-between rounded-lg  py-1 px-2 text-center text-white md:flex md:text-left"
      :class="[template ? 'bg-green-500' : 'bg-red-500']" >
      <div class="mb-4 flex flex-wrap items-center justify-center md:mb-0 md:justify-start">
        <span class="mr-2 [&>svg]:h-5 [&>svg]:w-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="2500" height="2442" viewBox="0 0 110.037 107.5" id="excel-app"><path fill="#207245" d="M57.55 0h7.425v10c12.513 0 25.025.025 37.537-.038 2.113.087 4.438-.062 6.275 1.2 1.287 1.85 1.138 4.2 1.225 6.325-.062 21.7-.037 43.388-.024 65.075-.062 3.638.337 7.35-.425 10.938-.5 2.6-3.625 2.662-5.713 2.75-12.95.037-25.912-.025-38.875 0v11.25h-7.763c-19.05-3.463-38.138-6.662-57.212-10V10.013C19.188 6.675 38.375 3.388 57.55 0z"></path><path fill="#fff" d="M64.975 13.75h41.25V92.5h-41.25V85h10v-8.75h-10v-5h10V62.5h-10v-5h10v-8.75h-10v-5h10V35h-10v-5h10v-8.75h-10v-7.5z"></path><path fill="#207245" d="M79.975 21.25h17.5V30h-17.5v-8.75z"></path><path fill="#fff" d="M37.025 32.962c2.825-.2 5.663-.375 8.5-.512a2607.344 2607.344 0 0 1-10.087 20.487c3.438 7 6.949 13.95 10.399 20.95a716.28 716.28 0 0 1-9.024-.575c-2.125-5.213-4.713-10.25-6.238-15.7-1.699 5.075-4.125 9.862-6.074 14.838-2.738-.038-5.476-.15-8.213-.263C19.5 65.9 22.6 59.562 25.912 53.312c-2.812-6.438-5.9-12.75-8.8-19.15 2.75-.163 5.5-.325 8.25-.475 1.862 4.888 3.899 9.712 5.438 14.725 1.649-5.312 4.112-10.312 6.225-15.45z"></path><path fill="#207245" d="M79.975 35h17.5v8.75h-17.5V35zM79.975 48.75h17.5v8.75h-17.5v-8.75zM79.975 62.5h17.5v8.75h-17.5V62.5zM79.975 76.25h17.5V85h-17.5v-8.75z"></path></svg>
      
        </span>
        <template v-if="template"><strong class="mr-1">TEMPLATE TERAKHIR DI UPLOAD TANGGAL {{ moment(template['updated_at']).format('YYYY-MM-DD HH:mm:ss')}}</strong> - Silahkan Upload Ulang Jika Ada Data Terbaru</template>
        <template v-else="template">  <strong class="mr-1">FILE TEMPLATE BELUM DIUPLOAD !!</strong> Silahkan Upload Template Excel Terlebih Dahulu</template>
        
      </div>
      <form @submit.prevent >
      <input type="file" ref="file" style="display: none"   @input="formUpload.file = $event.target.files[0]"  v-on:change="upload" />
      </form>
      <div class="flex items-center justify-center m-4">
        <a class="mr-4 inline-block rounded bg-neutral-50 px-2 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-neutral-800 shadow-[0_4px_9px_-4px_rgba(251,251,251,0.05)] transition duration-150 ease-in-out hover:bg-neutral-100 hover:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.05),0_4px_18px_0_rgba(203,203,203,0.05)] focus:bg-neutral-100 focus:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.05),0_4px_18px_0_rgba(203,203,203,0.05)] focus:outline-none focus:ring-0 active:bg-neutral-200 active:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.05),0_4px_18px_0_rgba(203,203,203,0.05)] dark:shadow-[0_4px_9px_-4px_rgba(251,251,251,0.05)] dark:hover:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)] dark:focus:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)] dark:active:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)]"
        @click="$refs.file.click()" role="button" data-te-ripple-init data-te-ripple-color="light">Upload Template</a>
       
      </div>
    </div>
  </section>
  <p v-if="$attrs.errors.error" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{$attrs.errors.error }}
                            </p>
  <!-- Section: Design Block -->
            </div>
  
</div>
        
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-8 space-y-6">
                <div
  class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
  <div
    class="border-b-2 border-neutral-100 px-2 py-3 dark:border-neutral-600 dark:text-neutral-50">
    REKAP
  </div>
  <div class="relative p-6 flex-auto">
   

    
<div class="grid grid-cols-2 md:grid-cols-2 gap-4 ">
    <div class="relative mb-2">
        <VueDatePicker class="text-xs text-xl shadow-[0_4px_9px_-4px_#3b71ca]" v-model="formSynch.month" month-picker />
    </div>
    <div class="relative mb-2 flex flex-wrap items-stretch">
      
  <button
    class="z-[2] inline-block rounded bg-primary px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white 
    shadow-[0_4px_9px_-4px_#3b71ca]
     transition duration-150 ease-in-out
      hover:bg-primary-600
      hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
       focus:z-[3] focus:bg-primary-600 
       focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
       focus:outline-none focus:ring-0 
       active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
       dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] 
       dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
       dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
       dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
    data-te-ripple-init
    type="button"
    id="button-addon2"
    v-on:click="filter" >
    FILTER
  </button>
  <a 
    class="z-[2] inline-block rounded bg-green-600 px-2 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white 
    shadow-[0_4px_9px_-4px_#3b71ca]
     transition duration-150 ease-in-out
      hover:bg-green-800
      hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]
       focus:z-[3] focus:bg-green-800 
       focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
       focus:outline-none focus:ring-0 
       active:bg-green-800 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] 
       dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] 
       dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
       dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] 
       dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]
      ml-4 
       "
    data-te-ripple-init
    type="button"
    id="button-addon2"
   
   
    :href="route('pajak.export.rekap', {
  bulan: formSynch.month.month + 1,
  tahun: formSynch.month.year
})" target="_blank">
    EXPORT EXCEL
  </a>
</div>
 <p v-if="formSynch.errors.error" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formSynch.errors.error }}
                            </p>
    </div>
    </div>
  <div class="p-6">
    <!--Tabs navigation-->
<ul
  class="mb-5 flex list-none flex-row flex-wrap border-b-0 pl-0"
  role="tablist"
  data-te-nav-ref>
  <li role="presentation" class="flex-grow basis-0 text-center">
    <a  v-if="isShowData === 1"
      
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
      data-te-nav-active
      role="tab"
      aria-controls="tabs1"
      aria-selected="true"
      >GU</a>
      <a  v-else
      href="#tabs1"
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
      @click="changeTab(1)"
      role="tab"
      aria-controls="tabs1"
      aria-selected="false"
      >GU</a>
      
  </li>
  <li role="presentation" class="flex-grow basis-0 text-center">
    <a v-if="isShowData === 2"
      
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
     
          data-te-nav-active
      role="tab"
      aria-controls="tabs2"
      aria-selected="true"
      >TU</a>
      <a v-else
      href="#tabs2"
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
      role="tab"
      aria-controls="tabs2"
      aria-selected="false"
      @click="changeTab(2)"
      >TU</a>
  </li>
  <li role="presentation" class="flex-grow basis-0 text-center">
    <a v-if="isShowData === 3"
      
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
     
          data-te-nav-active
      role="tab"
      aria-controls="tabs3"
      aria-selected="true"
      >UP</a>
      <a v-else
      href="#tabs3"
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
      role="tab"
      aria-controls="tabs3"
      aria-selected="false"
      @click="changeTab(3)"
      >UP</a>
  </li>
  <li role="presentation" class="flex-grow basis-0 text-center">
    <a v-if="isShowData === 4"
      
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
     
          data-te-nav-active
      role="tab"
      aria-controls="tabs4"
      aria-selected="true"
      >LS</a>
      <a v-else
      href="#tabs4"
      class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
      data-te-toggle="pill"
      role="tab"
      aria-controls="tabs4"
      aria-selected="false"
      @click="changeTab(4)"
      >LS</a>
  </li>
  
  
</ul>

<!--Tabs content-->
<div class="mb-6">
  <div
    class="opacity-100 transition-opacity duration-150 ease-linear "
    id="tabs-home02"
    role="tabpanel"
    aria-labelledby="tabs-home-tab02"
   
    v-show="isShowData === 1">
    <div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-1 sm:px-2 lg:px-8">
      <div class="overflow-hidden">
        <table class="min-w-full  text-xs font-light border-collapse">
          <thead class="border font-medium dark:border-neutral-500">
            <tr>
              <th scope="col" class="border px-2 py-1">NOMOR TBP/ KWT </th>
              <th scope="col" class="border px-2 py-1">NILAI BELANJA</th>
              <th scope="col" class="border px-2 py-1">URAIAN BELANJA</th>
              <th scope="col" class="border px-2 py-1">DASAR PENGENAAN PAJAK (DPP)</th>
              <th scope="col" class="border px-2 py-1">KODE AKUN</th>
              <th scope="col" class="border px-2 py-1">JENIS PAJAK</th>
              <th scope="col" class="border px-2 py-1">JUMLAH PAJAK</th>
              <th scope="col" class="border px-2 py-1 break-all">NPWP REKANAN/BENDAHARA</th>
              <th scope="col" class="border px-2 py-1 break-all">NAMA SKPD</th>
              <th scope="col" class="border px-2 py-1 ">NTPN</th>
              <th scope="col" class="text-center border px-2 py-1 ">VERIFIKASI</th>
              <th scope="col" class="border px-2 py-1 ">AKSI</th>


            </tr>
          </thead>
          <tbody>

            <template v-if="dataRekap['GU']?dataRekap['GU'].length:'0' > 0" v-for="( data, index ) in dataRekap['GU']">
            <tr class="border dark:border-neutral-500 border-pink-500">
              <td class=" border px-2 py-1 font-medium break-all  ">{{ data['tbp_kwt'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right ">{{ formatAsRupiah (data['nilai_belanja']) }}</td>
              <td class=" border px-2 py-1 break-all">{{ data['uraian_belanja'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right">{{formatAsRupiah(data['dpp'])}}</td>
              <td class="border whitespace-nowrap px-2 py-1">{{ data['kode_akun'] }}</td>
              <td class="border px-2 py-1">{{ data['jenis_pajak'] }}</td>
              <td class="border px-2 py-1 text-right">{{ formatAsRupiah(data['jumlah_pajak']) }}</td>
              <td class="border px-2 py-1">{{ data['npwp'] }}</td>
              <td class="border px-2 py-1 ">{{ data['nama_skpd'] }}</td>
              <td class="border px-2 py-1">{{ data['ntpn'] }}</td>
              <td class="border px-2 py-1 text-center">
                <div>
                  <input class="form-check-input appearance-none h-4 w-4 border
                                        border-gray-300 rounded-sm bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 
                                        focus:outline-none transition duration-200 mt-1 
                                        align-top bg-no-repeat bg-center bg-contain  
                                        mr-2 cursor-pointer" type="checkbox" 
                                        v-bind:value="data['ver']" v-bind:id="data.id" 
                                        :checked="data.ver == 1 ? true : false"
                                        @change="verifikasi(data,$event)">

                </div>
              
                                      </td>
              <td class="border px-2 py-1">
                <div class=" inline-flex rounded-md shadow-sm gap-2 " role="group">
                    <button type="button"  v-on:click="clickedit(data)"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                      <i class="fas fa-lg fa-pencil-alt"></i>
                    </button>
                    
                    <button type="button"   v-on="{ click: data.rekgaji ? () => viewRekgaji(data) : null }"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent  border rounded
                      shadow transition ease-in-out duration-150  
                      
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700"
                      :disabled="!data.rekgaji"
                      :class="!data.rekgaji?'cursor-not-allowed border-pink-500':'hover:bg-blue-500 hover:text-white border-blue-500'">
                      <i class="fas fa-lg fa-list"></i>
                    </button>
                    
                  </div>
                  

              </td>
              
            </tr>
              </template>
              <template v-else>
                <tr class="border dark:border-neutral-500">
                <td  class="border px-2 py-8 text-center" colspan="12">DATA TIDAK DITEMUKAN</td>
              </tr>
              </template>
            
        
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  </div>
  <div
    class="opacity-100 transition-opacity duration-150 ease-linear "
    id="tabs-tu"
    role="tabpanel"
    aria-labelledby="tabs-tu"
   
    v-show="isShowData === 2">
    <div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-1 sm:px-2 lg:px-8">
      <div class="overflow-hidden">
        <table class="min-w-full  text-xs font-light border-collapse">
          <thead class="border font-medium dark:border-neutral-500">
            <tr>
              <th scope="col" class="border px-2 py-1">NOMOR TBP/ KWT</th>
              <th scope="col" class="border px-2 py-1">NILAI BELANJA</th>
              <th scope="col" class="border px-2 py-1">URAIAN BELANJA</th>
              <th scope="col" class="border px-2 py-1">DASAR PENGENAAN PAJAK (DPP)</th>
              <th scope="col" class="border px-2 py-1">KODE AKUN</th>
              <th scope="col" class="border px-2 py-1">JENIS PAJAK</th>
              <th scope="col" class="border px-2 py-1">JUMLAH PAJAK</th>
              <th scope="col" class="border px-2 py-1 break-all">NPWP REKANAN/BENDAHARA</th>
              <th scope="col" class="border px-2 py-1 break-all">NAMA SKPD</th>
              <th scope="col" class="border px-2 py-1 ">NTPN</th>
              <th scope="col" class="text-center border px-2 py-1 ">VERIFIKASI</th>
              <th scope="col" class="border px-2 py-1 ">AKSI</th>


            </tr>
          </thead>
          <tbody>
            <template v-if="dataRekap['TU']?dataRekap['TU'].length:'0' > 0" v-for="( data, index ) in dataRekap['TU']">
            <tr class="border dark:border-neutral-500">
              <td class=" border px-2 py-1 font-medium break-all  ">{{ data['tbp_kwt'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right ">{{ formatAsRupiah (data['nilai_belanja']) }}</td>
              <td class=" border px-2 py-1 break-all">{{ data['uraian_belanja'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right">{{formatAsRupiah(data['dpp'])}}</td>
              <td class="border whitespace-nowrap px-2 py-1">{{ data['kode_akun'] }}</td>
              <td class="border px-2 py-1">{{ data['jenis_pajak'] }}</td>
              <td class="border px-2 py-1 text-right">{{ formatAsRupiah(data['jumlah_pajak']) }}</td>
              <td class="border px-2 py-1">{{ data['npwp'] }}</td>
              <td class="border px-2 py-1 ">{{ data['nama_skpd'] }}</td>
              <td class="border px-2 py-1">{{ data['ntpn'] }}</td>
              <td class="border px-2 py-1 text-center">
                <div>
                  <input class="form-check-input appearance-none h-4 w-4 border
                                        border-gray-300 rounded-sm bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 
                                        focus:outline-none transition duration-200 mt-1 
                                        align-top bg-no-repeat bg-center bg-contain  
                                        mr-2 cursor-pointer" type="checkbox" 
                                        v-bind:value="data['ver']" v-bind:id="data.id" 
                                        :checked="data.ver == 1 ? true : false"
                                        @change="verifikasi(data,$event)">

                </div>
              
                                      </td>
              <td class="border px-2 py-1">
                <div class=" inline-flex rounded-md shadow-sm gap-2" role="group">
                    <button type="button"  v-on:click="clickedit(data)"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                      <i class="fas fa-lg fa-pencil-alt"></i>
                    </button>
                    <button type="button"  v-on="{ click: data.rekgaji ? () => viewRekgaji(data) : null }"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent  border rounded
                      shadow transition ease-in-out duration-150  
                      
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700"
                      :disabled="!data.rekgaji"
                      :class="!data.rekgaji?'cursor-not-allowed border-pink-500':'hover:bg-blue-500 hover:text-white border-blue-500'">
                      <i class="fas fa-lg fa-list"></i>
                    </button>
                    
                  </div>

              </td>
              
            </tr>
              </template>
              <template v-else>
                <tr class="border dark:border-neutral-500">
                <td  class="border px-2 py-8 text-center" colspan="12">DATA TIDAK DITEMUKAN</td>
              </tr>
              </template>
        
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  </div>
  <div
    class="opacity-100 transition-opacity duration-150 ease-linear "
    id="tabs-up"
    role="tabpanel"
    aria-labelledby="tabs-up"
   
    v-show="isShowData === 3">
    <div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-1 sm:px-2 lg:px-8">
      <div class="overflow-hidden">
        <table class="min-w-full  text-xs font-light border-collapse">
          <thead class="border font-medium dark:border-neutral-500">
            <tr>
              <th scope="col" class="border px-2 py-1">NOMOR TBP/ KWT</th>
              <th scope="col" class="border px-2 py-1">NILAI BELANJA</th>
              <th scope="col" class="border px-2 py-1">URAIAN BELANJA</th>
              <th scope="col" class="border px-2 py-1">DASAR PENGENAAN PAJAK (DPP)</th>
              <th scope="col" class="border px-2 py-1">KODE AKUN</th>
              <th scope="col" class="border px-2 py-1">JENIS PAJAK</th>
              <th scope="col" class="border px-2 py-1">JUMLAH PAJAK</th>
              <th scope="col" class="border px-2 py-1 break-all">NPWP REKANAN/BENDAHARA</th>
              <th scope="col" class="border px-2 py-1 break-all">NAMA SKPD</th>
              <th scope="col" class="border px-2 py-1 ">NTPN</th>
              <th scope="col" class="text-center border px-2 py-1 ">VERIFIKASI</th>
              <th scope="col" class="border px-2 py-1 ">AKSI</th>


            </tr>
          </thead>
          <tbody>
            <template v-if="dataRekap['UP']?dataRekap['UP'].length:'0' > 0" v-for="( data, index ) in dataRekap['UP']">
            <tr class="border dark:border-neutral-500 " :class="data.rekgaji?'border-2 border-pink-500':''">
              <td class=" border px-2 py-1 font-medium break-all  ">{{ data['tbp_kwt'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right ">{{ formatAsRupiah (data['nilai_belanja']) }}</td>
              <td class=" border px-2 py-1 break-all">{{ data['uraian_belanja'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right">{{formatAsRupiah(data['dpp'])}}</td>
              <td class="border whitespace-nowrap px-2 py-1">{{ data['kode_akun'] }}</td>
              <td class="border px-2 py-1">{{ data['jenis_pajak'] }}</td>
              <td class="border px-2 py-1 text-right">{{ formatAsRupiah(data['jumlah_pajak']) }}</td>
              <td class="border px-2 py-1">{{ data['npwp'] }}</td>
              <td class="border px-2 py-1 ">{{ data['nama_skpd'] }}</td>
              <td class="border px-2 py-1">{{ data['ntpn'] }}</td>
              <td class="border px-2 py-1 text-center">
                <div>
                  <input class="form-check-input appearance-none h-4 w-4 border
                                        border-gray-300 rounded-sm bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 
                                        focus:outline-none transition duration-200 mt-1 
                                        align-top bg-no-repeat bg-center bg-contain  
                                        mr-2 cursor-pointer" type="checkbox" 
                                        v-bind:value="data['ver']" v-bind:id="data.id" 
                                        :checked="data.ver == 1 ? true : false"
                                        @change="verifikasi(data,$event)">

                </div>
              
                                      </td>
              <td class="border px-2 py-1">
                <div class=" inline-flex rounded-md shadow-sm gap-2" role="group">
                    <button type="button"  v-on:click="clickedit(data)"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                      <i class="fas fa-lg fa-pencil-alt"></i>
                    </button>
                    <button type="button"   v-on="{ click: data.rekgaji ? () => viewRekgaji(data) : null }"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent  border  rounded
                      shadow transition ease-in-out duration-150  
                      
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700"
                      :disabled="!data.rekgaji"
                      :class="!data.rekgaji?'cursor-not-allowed border-pink-500':'hover:bg-blue-500 hover:text-white border-blue-500'">
                      <i class="fas fa-lg fa-list"></i>
                    </button>
                    
                  </div>

              </td>
              
            </tr>
              </template>
              <template v-else>
                <tr class="border dark:border-neutral-500">
                <td  class="border px-2 py-8 text-center" colspan="12">DATA TIDAK DITEMUKAN</td>
              </tr>
              </template>
        
        
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  </div>
  <div
    class="opacity-100 transition-opacity duration-150 ease-linear "
    id="tabs-up"
    role="tabpanel"
    aria-labelledby="tabs-up"
   
    v-show="isShowData === 4">
    <div class="flex flex-col">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-1 sm:px-2 lg:px-8">
      <div class="overflow-hidden">
        <table class="min-w-full  text-xs font-light border-collapse">
          <thead class="border font-medium dark:border-neutral-500">
            <tr>
              <th scope="col" class="border px-2 py-1">NOMOR TBP/ KWT</th>
              <th scope="col" class="border px-2 py-1">NILAI BELANJA</th>
              <th scope="col" class="border px-2 py-1">URAIAN BELANJA</th>
              <th scope="col" class="border px-2 py-1">DASAR PENGENAAN PAJAK (DPP)</th>
              <th scope="col" class="border px-2 py-1">KODE AKUN</th>
              <th scope="col" class="border px-2 py-1">JENIS PAJAK</th>
              <th scope="col" class="border px-2 py-1">JUMLAH PAJAK</th>
              <th scope="col" class="border px-2 py-1 break-all">NPWP REKANAN/BENDAHARA</th>
              <th scope="col" class="border px-2 py-1 break-all">NAMA SKPD</th>
              <th scope="col" class="border px-2 py-1 ">NTPN</th>
              <th scope="col" class="text-center border px-2 py-1 ">VERIFIKASI</th>
              <th scope="col" class="border px-2 py-1 ">AKSI</th>


            </tr>
          </thead>
          <tbody>
            <template v-if="dataRekap['LS']?dataRekap['LS'].length:'0' > 0" v-for="( data, index ) in dataRekap['LS']">
            <tr class="border dark:border-neutral-500" :class="data.rekgaji?'border-2 border-pink-500':''">
              <td class=" border px-2 py-1 font-medium break-all  ">{{ data['tbp_kwt'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right ">{{ formatAsRupiah (data['nilai_belanja']) }}</td>
              <td class=" border px-2 py-1 break-all">{{ data['uraian_belanja'] }}</td>
              <td class="border whitespace-nowrap px-2 py-1 text-right">{{formatAsRupiah(data['dpp'])}}</td>
              <td class="border whitespace-nowrap px-2 py-1">{{ data['kode_akun'] }}</td>
              <td class="border px-2 py-1">{{ data['jenis_pajak'] }}</td>
              <td class="border px-2 py-1 text-right">{{ formatAsRupiah(data['jumlah_pajak']) }}</td>
              <td class="border px-2 py-1">{{ data['npwp'] }}</td>
              <td class="border px-2 py-1 ">{{ data['nama_skpd'] }}</td>
              <td class="border px-2 py-1">{{ data['ntpn'] }}</td>
              <td class="border px-2 py-1 text-center">
                <div>
                  <input class="form-check-input appearance-none h-4 w-4 border
                                        border-gray-300 rounded-sm bg-white 
                                        checked:bg-blue-600 checked:border-blue-600 
                                        focus:outline-none transition duration-200 mt-1 
                                        align-top bg-no-repeat bg-center bg-contain  
                                        mr-2 cursor-pointer" type="checkbox" 
                                        v-bind:value="data['ver']" v-bind:id="data.id" 
                                        :checked="data.ver == 1 ? true : false"
                                        @change="verifikasi(data,$event)">

                </div>
              
                                      </td>
              <td class="border px-2 py-1">
                <div class=" inline-flex rounded-md shadow-sm gap-2" role="group">
                    <button type="button"  v-on:click="clickedit(data)"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-blue-500 rounded
                      shadow transition ease-in-out duration-150  
                      hover:bg-blue-500 hover:text-white 
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700">
                      <i class="fas fa-lg fa-pencil-alt"></i>
                    </button>
                    <button type="button"   v-on="{ click: data.rekgaji ? () => viewRekgaji(data) : null }"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent  border  rounded
                      shadow transition ease-in-out duration-150  
                      
                      focus:outline-none focus:ring-2 focus:ring-blue-700 focus:bg-blue-500 focus:text-white focus:z-[1]
                      dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-blue-700 dark:focus:bg-blue-700"
                      :disabled="!data.rekgaji"
                      :class="!data.rekgaji?'cursor-not-allowed border-pink-500':'hover:bg-blue-500 hover:text-white border-blue-500'"
                      >
                      <i class="fas fa-lg fa-list"></i>
                    </button>
                    
                  </div>

              </td>
              
            </tr>
              </template>
              <template v-else>
                <tr class="border dark:border-neutral-500">
                <td  class="border px-2 py-8 text-center" colspan="12">DATA TIDAK DITEMUKAN</td>
              </tr>
              </template>
            
        
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  </div>
  
</div>
   
  </div>
</div>
            </div>
        
            </div>
        
    </AuthenticatedLayout>
    <Modal :show="showList" @close="closeList" :maxWidth="'7xl'">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    List Rekening 5.1.01.01
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
              <div class="overflow-hidden">
                <table class="w-full border border-collapse table-auto">
      <thead class="">
        <tr class="text-base font-bold text-left bg-gray-50">
          <th class="px-4 py-3 border-b-2 border-pink-500">Kode Rekening</th>
          <th class="px-4 py-3 border-b-2 border-blue-500">Uraian Belanja</th>
          <th class="px-4 py-3 border-b-2 border-green-500">Nilai Belanja</th>
          <th class="px-4 py-3 border-b-2 border-red-500">Jenis Pajak</th>
          <th class="px-4 py-3 border-b-2 border-purple-500">Jumlah Pajak</th>
          <th class="px-4 py-3 text-center border-b-2 border-yellow-500 sm:text-left">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-sm font-normal text-gray-700">

        <template  v-for="( data, index ) in listDataRekGaji">
          <tr class="py-10 border-b border-gray-200 hover:bg-gray-100">
              <td class="px-4 py-4">
                {{ data['kode_rekening'] }}
              </td>
              <td class="px-4 py-4">
               {{ data['uraian_belanja'] }}
              </td>
              
              <td class="px-4 py-4 text-right" contenteditable>
                {{ data['nilai_belanja']?formatAsRupiah(data['nilai_belanja']):'-' }}
              </td>
              <td class="px-4 py-4">
               {{ data['jenis_pajak_sipd'] }}
              </td>
              <td class="px-4 py-4 text-right">
                {{ data['jumlah_pajak']?formatAsRupiah(data['jumlah_pajak']):'-' }}
              </td>
              <td class="px-4 py-4 text-center">
                <input class="form-check-input appearance-none h-4 w-4 border
                  border-gray-300 rounded-sm bg-white 
                  checked:bg-blue-600 checked:border-blue-600 
                  focus:outline-none transition duration-200 mt-1 
                  align-top bg-no-repeat bg-center bg-contain  
                  mr-2 cursor-pointer" type="checkbox" 
                  v-bind:value="data['visible']" v-bind:id="'cv-'+data.id" 
                  :checked="data.visible == 1 ? true : false"
                  @change="visible(data,$event)">
              </td>
              
          </tr>
        </template>
        
        <tr class="py-10 border-b border-gray-200  bg-gray-50">
          <td class="px-4 py-4 text-right font-bold border-t-2 border-pink-500" >
           
            </td>
          <td class="px-4 py-4 text-right font-bold border-t-2 border-blue-500">
            TOTAL NILAI BELANJA
            </td>
              <td class="px-4 py-4 text-right border-t-2 border-green-500">
                {{ jumNilaiBelanja?formatAsRupiah(jumNilaiBelanja):'-' }}
              </td>
              <td class="px-4 py-4 text-right border-t-2 border-red-500 " >
           
            </td>
            <td class="px-4 py-4 text-right border-t-2 border-purple-500 " >
           
          </td>
          <td class="px-4 py-4 text-right border-t-2 border-yellow-500 " >
           
          </td>
        </tr>
      
      </tbody>
    </table>
       
          </div>
            </div>
          </div>
    </Modal>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    UBAH
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                  <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="nomorTbp" value="Nomor TBP" class="uppercase " />
                            <TextInput
                                id="nomorTbp"
                                ref="nomorTbpInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Nomor TBP"
                                v-model="form.nomorTbp"
                            />
                            <p v-if="form.errors.nomorTbp" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.nomorTbp }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                            <InputLabel for="uraianBelanja" value="Uraian Belanja" class="uppercase " />
                            <TextInput
                                id="uraianBelanja"
                                ref="uraianBelanjaInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Uraian Belanja"
                                v-model="form.uraianBelanja"
                            />
                            <p v-if="form.errors.uraianBelanja" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.uraianBelanja }}
                            </p>
                        </div>
                      
                  </div>
                   <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                    <div class="relative mb-2">
                            <InputLabel for="nilaiBelanja" value="Nilai Belanja" class="uppercase " />
                            <TextInput
                                id="nilaiBelanja"
                                ref="nilaiBelanjaInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Nilai Belanja"
                                v-model="form.nilaiBelanja"
                            />
                            <p v-if="form.errors.nilaiBelanja" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.nilaiBelanja }}
                            </p>
                        </div>
                       
                         <div class="relative mb-2">
                            <InputLabel for="dpp" value="Dasar Pengenaan Pajak" class="uppercase " />
                            <TextInput
                                id="dpp"
                                ref="dppInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="dpp"
                                v-model="form.dpp"
                            />
                            <p v-if="form.errors.dpp" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.dpp }}
                            </p>
                        </div>
                   </div>
                   <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                    <div class="relative mb-2">
                            <InputLabel for="jenisPajak" value="Jenis Pajak" class="uppercase " />
                            <TextInput
                                id="jenisPajak"
                                ref="jenisPajakInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Jenis Pajak"
                                v-model="form.jenisPajak"
                            />
                            <p v-if="form.errors.jenisPajak" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.jenisPajak }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                            <InputLabel for="jumlahPajak" value="Jumlah Pajak" class="uppercase " />
                            <TextInput
                                id="jumlahPajak"
                                ref="jumlahPajakInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Jumlah Pajak"
                                v-model="form.jumlahPajak"
                            />
                            <p v-if="form.errors.jumlahPajak" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.jumlahPajak }}
                            </p>
                        </div>
                   </div>
                   <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                    <div class="relative mb-2">
                            <InputLabel for="kodeAkun" value="Kode Akun" class="uppercase " />
                            <TextInput
                                id="kodeAkun"
                                ref="kodeAkunInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Kode Akun"
                                v-model="form.kodeAkun"
                            />
                            <p v-if="form.errors.kodeAkun" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.kodeAkun }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                            <InputLabel for="ntpn" value="NTPN" class="uppercase " />
                            <TextInput
                                id="ntpn"
                                ref="ntpnInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="NTPN"
                                v-model="form.ntpn"
                            />
                            <p v-if="form.errors.ntpn" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.ntpn }}
                            </p>
                        </div>
                   </div>
                   <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                    <div class="relative mb-2">
                            <InputLabel for="npwp" value="NPWP REKANAN / BENDAHARA" class="uppercase " />
                            <TextInput
                                id="npwp"
                                ref="npwpInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="NPWP"
                                v-model="form.npwp"
                            />
                            <p v-if="form.errors.npwp" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{form.errors.npwp }}
                            </p>
                        </div>
                        <div class="relative mb-2">
                                <input class="form-check-input appearance-none h-4 w-4 border
                                    border-gray-300 rounded-sm bg-white 
                                    checked:bg-blue-600 checked:border-blue-600 
                                    focus:outline-none transition duration-200 mt-9 
                                    align-top bg-no-repeat bg-center bg-contain float-left 
                                    mr-2 cursor-pointer" type="checkbox"  v-bind:id="'id_verifikasi'" :checked="form.verifikasi == 1 ? true : false" @change="verifikasiEdit(data,$event)"
                                    >
                                <label class="form-check-label inline-block  mt-8 text-gray-800" for="id_verifikasi">
                                    Verifikasi
                                </label>
                            
                            </div>
                   </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpanPerubahan" 
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
               
               
                    Simpan
                
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
    
export default {
    component:{
      VueDatePicker,
    
    },
    props:{
        template : Object,
        dataRekap : Object
    },

    data() {
        return {
          isShowData :1,
          showModal: false,
          showList : false,
          listDataRekGaji : [],
          jumNilaiBelanja : null,
          idPajakGaji:null,
          formVisible: this.$inertia.form({
            'id' : null,
            'visible' : null
          }),
          // listData:this.dataRekap,
          selectedItems: _.map(this.dataRekap, 'ver'),
          formVerifikasi: this.$inertia.form({
            'id' : null,
            'ver' : null,
            'tbp':null,
          }),
          formUpload: this.$inertia.form({
            'file' : null,
          }),
          form: this.$inertia.form({
            'id' : null,
            'nomorTbp' : null,
            'nilaiBelanja' : null,
            'uraianBelanja' : null,
            'dpp' : null,
            'kodeAkun' : null,
            'jenisPajak' : null,
            'jumlahPajak' : null,
            'npwp' : null,
            'ntpn' : null,
            'verifikasi': null,
            'rekgaji' : false
          }),
          
          formSynch: this.$inertia.form({
            'month' :{
              'month': new Date().getMonth(),
              'year': new Date().getFullYear()
            } 
            
            
          }),
        };
    },
    computed: {
    
    },
    methods: {
      formatAsRupiah(amount) {
        return amount.toLocaleString("id-ID", {
          // style: "currency",
          // currency: "IDR",
          minimumFractionDigits: 2,
        });
      },

      viewRekgaji : function(value) {
        // console.log(value.tbp_kwt);
        // console.log('tes');
          this.idPajakGaji=value.id;
          NProgress.start()
          axios.post('/pajak/get-list-rek-gaji', {
            "tbp_kwt":value.tbp_kwt
          })
          .then((res) => {
              //get list rekening gaji berdasarkan nomor sp2d
              this.listDataRekGaji=res.data;
              this.showList = !this.showList;
              let sum = 0
              this.listDataRekGaji.forEach(  (item)  => {
                  if (item.visible == 1) {
                    sum += (item.nilai_belanja)
                  }
              });
              this.jumNilaiBelanja = sum;
              NProgress.done();
          })
          .catch((error) => {
              //jika error.response.status Check status code
              NProgress.done();
          }).finally(() => {
              //selesai 
              NProgress.done();
        });
      
        },
        clickedit(value){
            
                this.showModal = !this.showModal;
                this.form.id = value.id;
                this.form.nomorTbp = value.tbp_kwt;
                this.form.nilaiBelanja = value.nilai_belanja;
                this.form.uraianBelanja = value.uraian_belanja;
                this.form.dpp = value.dpp;
                this.form.kodeAkun = value.kode_akun;
                this.form.jenisPajak = value.jenis_pajak;
                this.form.jumlahPajak = value.jumlah_pajak;
                this.form.npwp = value.npwp;
                this.form.ntpn = value.ntpn;
                this.form.verifikasi = value.ver;
                this.form.rekgaji = value.rekgaji?value.rekgaji:false;
            },
      closeModal(){
                
                this.showModal = !this.showModal;
              
        },
      closeList(){
              
              this.showList = !this.showList;
              this.idPajakGaji=null;
            
      },
      verifikasiEdit: function(value,event) {
      
        if (event.target.checked) {
            this.form.verifikasi = 1;
        }else{
          this.form.verifikasi = 0;
        }
      },
      verifikasi  : function(value,event) {
        
            if (event.target.checked) {
                this.formVerifikasi.id = value.id;
                this.formVerifikasi.ver = 1;
            }else{
              this.formVerifikasi.id = value.id;
              this.formVerifikasi.ver = 0;
            
            }
            
            if (value.rekgaji) {
              this.formVerifikasi.tbp = value.tbp_kwt;
            }
          
            this.formVerifikasi.put(route('pajak.verifikasi', value.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                      // const indexToUpdate = this.listData['UP'].findIndex(item => item.id === value.id);
                      // if (indexToUpdate !== -1) {
                      //   this.listData['UP'][indexToUpdate].ver = this.formVerifikasi.ver;
                      // } 
                    }
                })
            
            
        },
        visible:function(value,event){
            if (event.target.checked) {
              this.formVisible.id = value.id;
              this.formVisible.visible = 1;
            }else{
              this.formVisible.id = value.id;
              this.formVisible.visible = 0;
            }
            NProgress.start()
            axios.put(route('pajak.visible.rekgaji', value.id),  {
              id: this.formVisible.id,
              visible: this.formVisible.visible
            })
            .then((res) => {
                  //jika sukses
                  const indexToUpdate = this.listDataRekGaji.findIndex(item => item.id === value.id);
                  if (indexToUpdate !== -1) {
                    this.listDataRekGaji[indexToUpdate].visible = this.formVisible.visible;
                  } 
                  NProgress.done()
            })
            .catch((error) => {
                  //jika error.response.status Check status code
                NProgress.done()
            }).finally(() => {
                  //selesai 
                  NProgress.done()
                  let sum = 0
                  this.listDataRekGaji.forEach(  (item)  => {
                    if (item.visible == 1) {
                      sum += (item.nilai_belanja)
                    }
                  });
                  this.jumNilaiBelanja = sum;

                  const indexList = this.dataRekap['LS'].findIndex(item => item.id === this.idPajakGaji);
                  if (indexList !== -1) {
                    this.dataRekap['LS'][indexList].nilai_belanja = sum;
                  } 
                  
            });

            // router.put(route('pajak.visible.rekgaji', value.id),
            //   {
            //     id: this.formVisible.id,
            //     visible: this.formVisible.visible
            //   },
            //   { 
            //     replace: true,
            //     preserveState: true,
            //     onSuccess: (page) => {
                  
            //       const indexToUpdate = this.listDataRekGaji.findIndex(item => item.id === value.id);
            //       if (indexToUpdate !== -1) {
            //         this.listDataRekGaji[indexToUpdate].visible = this.formVisible.visible;
            //       } 

            //     },
            //     onError: (errors) => {
                  
            //     },
            //     onCancel: () => {
                  
            //     },
            //     onFinish: visit => {
            //       let sum = 0
            //       this.listDataRekGaji.forEach(  (item)  => {
            //         if (item.visible == 1) {
            //           sum += (item.nilai_belanja)
            //         }
            //       });
            //       this.jumNilaiBelanja = sum;
            //     },
            //   }
            // );

            // router.put(route('pajak.visible.rekgaji', value.id), {
            //         preserveScroll: true,
            //         preserveState: true,
            //         onSuccess: () => {
            //           const indexToUpdate = this.listDataRekGaji.findIndex(item => item.id === value.id);
            //           if (indexToUpdate !== -1) {
            //             this.listDataRekGaji[indexToUpdate].visible = this.formVisible.visible;
            //           } 
                      
            //         },  onFinish: visit => {
            //           let sum = 0
            //           this.listDataRekGaji.forEach(  (item)  => {
            //               if (item.visible == 1) {
            //                 sum += (item.nilai_belanja)
            //               }
            //           });
            //           this.jumNilaiBelanja = sum;
            //         },
            //     })
        },
        upload() {
          this.formUpload.post(route('pajak.upload.excel'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                      this.formUpload.reset();
                      this.formUpload.clearErrors();
                    },
                    onFinish: visit => {
                      this.formUpload.reset();
                      this.formUpload.clearErrors();
                    },
                })
        },
        exportExcel(){
          // axios.post('/pajak/export-rekap', this.formSynch)
          //        .then((res) => {
          //            //jika sukses
          //         this.listData=res.data;
          //        })
          //        .catch((error) => {
          //            //jika error.response.status Check status code
          //        }).finally(() => {
          //            //selesai 
          //       });
          router.get('/pajak/export-rekap',
              {
              bulan: this.formSynch.month.month+1,
              tahun: this.formSynch.month.year
              },
              { 
                replace: true,
                preserveState: true 
              }
            )
        },
        filter() {
          router.get('/pajak',
              {
              bulan: this.formSynch.month.month+1,
              tahun: this.formSynch.month.year
              },
              { 
                replace: true,
                preserveState: true 
              }
            )
              // axios.post('/pajak/filter', this.formSynch)
              //    .then((res) => {
              //        //jika sukses
              //     this.listData=res.data;
              //    })
              //    .catch((error) => {
              //        //jika error.response.status Check status code
              //    }).finally(() => {
              //        //selesai 
              //   });
          
        },
        simpanPerubahan() {
            this.form.put(route('pajak.update', this.form.id), {
                      preserveScroll: true,
                      preserveState: true,
                      onSuccess: () => {
                        // this.listData=this.dataRekap;
                        this.form.reset();
                        this.closeModal();
                      },
                  })
        },
        changeTab(tab) {
          this.isShowData = tab;
        }

    },

    
};
</script>
