<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';


import { Link } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Dialog from '@/Components/Dialog.vue';
import Table from "@/Components/Tables/Table.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import NProgress from 'nprogress'
import ToastList from '@/Components/Notifications/ToastList.vue';
import toast from '@/Stores/toast.js';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>
    <Head>
        <title>Manajemen {{titleTable}} </title>
        <meta name="description" content="halaman manajemen menu" />
        <!-- <link rel="icon" type="image/svg+xml" href="/favicon.svg" /> -->
    </Head>

    <AdminLayout>
        <template #textnavbar>
            manajemen {{titleTable}}
        </template>
        <template #notif>
            <ToastList/>
        </template>
        <template #header>
            <header-stats>

                <template #kontenheader>
                    
                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">

            <div class="w-full mb-12 px-4">
                <Table @klik="klikMethod" :list=data.data :header=header :namaTitle="`List ${titleTable}`">
                    <template #button>
                       
                        <div class="hidden md:block">
                            
                            <ButtonTambah v-if="buttonTambah" @click="tambah">Tambah</ButtonTambah>
                        </div>

                        <div class="md:min-w-full md:hidden block">
                            <div class="flex flex-wrap">

                        
                                <div class="w-full">
                                    
                                    <button
                                        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                                        type="button">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </template>
                    <template #pencarian>
                        <div class="w-full lg:w-full mt-5 ">

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
                                        <input type="search" id="search" 
                                            v-model="search" v-on:keyup.enter="cari"
                                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Pencarian" required>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </template>

                </Table>
                <div
                            class="flex flex-col items-center w-full px-4 py-2 text-sm text-gray-500 sm:justify-between sm:space-y-0 sm:flex-row">

                            <div id="fromTo"> <p class="flex">Menampilkan&nbsp;<span class="font-bold">{{ data.from }} 
                                </span>&nbsp; sampai &nbsp; <span class="font-bold"> {{ data.to }}
                                </span>&nbsp; dari &nbsp;<span class="font-bold">{{ data.total }}
                                </span>  &nbsp; data</p>
                            </div>

                            <div class="flex items-center justify-between space-x-2">
                                <div id="prev"></div>
                                <div class="flex flex-row   space-x-1" id="halaman">
                                    <template v-if="data.current_page == 1">
                                        <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3>First Page</h3>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                        :href="data.first_page_url" @click.prevent="getHalaman(data.first_page_url)" ><h3>First Page</h3></Link>
                                    </template>
                                    <template  v-for="paging in data?data.links:[]" >
                                        <template v-if="paging.active == false && paging.url == null">
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else-if="paging.active == true && paging.url != null">
                                            
                                            <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg " >
                                                <h3 v-html="paging.label"></h3>
                                            </div>
                                        </template>
                                        <template v-else>

                                            <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                            :href="paging.url"  @click.prevent="getHalaman(paging.url)"><h3 v-html="paging.label"></h3></Link>
                                        
                                        </template>
                                    </template>
                                    <template v-if="data.current_page == data.last_page">
                                        <div class="flex px-2 py-px border border-blue-400 disabled:opacity-50 shadow-md drop-shadow-lg  " >
                                                <h3>Last Page</h3>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Link class="flex px-2 py-px text-white bg-blue-400 border border-blue-400 hover:bg-blue-400 hover:text-white shadow-md drop-shadow-lg" 
                                            :href="data.last_page_url" @click.prevent="getHalaman(data.last_page_url)" ><h3>Last Page</h3></Link>
                                    </template>
                                </div>
                                <div id="next"></div>

                            </div>
                        </div>
            </div>

        </div>
        

    </AdminLayout>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Tambah
                </h3>
            </div>
            <div class="relative p-6 flex-auto">
                <form >
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2">
                            <InputLabel for="permission" value="Permission" class="" />
                            <TextInput
                                id="permission"
                                ref="permissionInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="Permission"
                                v-model="forminstance.nama"
                            />
                            <p v-if="forminstance.errors.nama" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{forminstance.errors.nama }}
                            </p>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                :class="{ 'opacity-25': forminstance.processing }" :disabled="forminstance.processing">
                <div v-if="editMode == true">
                    Simpan Perubahan
                </div>
                <div v-else>
                    Simpan
                </div>
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <Modal :show="showModalDetailTable" @close="closeModalDetailTable" :maxWidth="'5xl'">
        <div class="p-2">
            <div class="mx-4 flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold uppercase">
                    DETAIL {{ detailNama }}
                </h3>
            </div>

            <div class="relative p-6 flex-auto animatecss animatecss-fadeIn">
                <div class="overflow-hidden">

                    <table class="w-full border border-collapse table-auto">
                        
                        <tbody class="text-sm font-normal text-gray-700">
                            <template v-for="( data, index ) in detailData.display_name" :key="index">
                                <tr class="py-10  border-gray-200 ">
                                    <th class="px-2 py-2 w-1/4 border text-left">
                                        {{ data.display_name }}
                                    </th>
                                    <td class="px-2 py-2 border">
                                        {{ detailData.data[data.field] }}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-1 flex justify-end mr-6 mb-4">
                <SecondaryButton @click="closeModalDetailTable">
                    Tutup
                </SecondaryButton>
            </div>
        </div>
    </Modal>
    <Dialog :show="dialogHapus" @close="closeDialogHapus()">
        <div class="md:flex items-center">
        
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <p class="font-bold">Hapus Data</p>
                <p class="text-sm text-gray-700 mt-1">Anda Yakin Akan Menghapus Data Yang Dipilih?
                </p>
            </div>
        </div>
    
        <div class="text-center md:text-right mt-4 md:flex md:justify-end">
            <button v-on:click="hapusAksi()"
                class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 
                text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2 " :class="{ 'opacity-25': prosesRequest }" :disabled="prosesRequest">
                Ya, Hapus</button>
            <button v-on:click="closeDialogHapus()" class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
            md:mt-0 md:order-1">Batal</button>
        </div>
    </Dialog>

</template>

<script>

export default {
    props: {
        header: Object,
        data: Object,
        titleTable : String,
        slug : String,
        dataSearch : String,
        buttonTambah : Boolean
    },
    components: {

    },
    computed: {
    
    },
    data() {
        return {
            showModalDetailTable: false,
            dialogHapus:false,
            objRow : null,
            detailNama: null,
            search : this.dataSearch,
            detailData: {},
            prosesRequest:false,

            forminstance: this.$inertia.form({
                nama: null,
            }),
            showModal: false,
            editMode: false,    
            
        };
    },
    created(){
    
    },
    methods: {

        tambah() {

            // Inertia.get(route(this.slug+'.create'), {}, { replace: true })
            this.editMode = false;
            this.objRow = null;
            this.showModal = !this.showModal;
            this.forminstance.reset()
            this.forminstance.clearErrors()
        },

        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
            this.forminstance.reset();
            this.forminstance.clearErrors()
        },

        klikMethod(value) {
            const method = value.action;
            this[method](value.value)
        },

        edit(value) {
            Inertia.get(route(this.slug+'.edit',value.id), {}, { replace: true })
        },

        lihatDetail(value) {
            NProgress.start()
            axios.get(route(this.slug+'.show', value.id), {
            })
                .then((res) => {
                    //jika sukses
                    this.showModalDetailTable = !this.showModalDetailTable;
                    this.detailData = res.data;
                    NProgress.done()
                    console.log(res);
                    
                })
                .catch((error) => {
                    //jika error.response.status Check status code
                    NProgress.done()
                    this.showModalDetailTable = false;

                }).finally(() => {
                    //selesai 
                    NProgress.done();

                });

        },
        closeModalDetailTable() {
            this.showModalDetailTable = !this.showModalDetailTable;
            this.detailNama = null;
        },
        hapus(value) {
            this.objRow = value;
            this.dialogHapus = !this.dialogHapus;
        },
        hapusAksi(){
            this.prosesRequest = true;
            Inertia.delete(route(this.slug+'.destroy',this.objRow.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.prosesRequest = false;
                        this.dialogHapus = !this.dialogHapus;
                        this.objRow = null;
                        toast.add({
                            message: 'Sukses Hapus Data',
                            category : 'info'
                        })
                    },
                    onFinish:()=>{
                        this.prosesRequest = false;
                        this.objRow = null;
                    },
                    onError: errors => {
                        this.prosesRequest = false;
                        toast.add({
                            message: errors.error,
                            category : 'warning',
                            duration : 10000
                        })
                        this.dialogHapus = !this.dialogHapus;
                        this.objRow = null;
                    },
            });
        },
        closeDialogHapus: function () {
            this.dialogHapus = !this.dialogHapus;
        },
        cari(){
            Inertia.get(route(this.slug+'.index'), {
                search: this.search 
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
            
        },
        getHalaman(value){
            Inertia.get(value, {
            
            }, {
                replace: true,
                preserveScroll: true,
                preserveState: true  
            })
        }
    },
};
</script>
