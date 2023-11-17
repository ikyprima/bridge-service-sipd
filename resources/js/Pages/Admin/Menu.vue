<script setup>
import AdminLayout from '@/Layouts/Admin.vue';
import ButtonTambah from '@/Components/Buttons/ButtonTambah.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import Multiselect from '@vueform/multiselect'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import Card from "@/Components/Cards/CardKosong.vue";
import { router } from '@inertiajs/vue3'

router.reload({ only: ['admin/menu'] });

</script>

<template>
    <Head title="Manajemen Menu" />

    <AdminLayout>
        <template #textnavbar>
            manajemen menu
        </template>

        <template #header>
            <header-stats>

                <template #kontenheader>

                </template>

            </header-stats>
        </template>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">

                <card :list=listMenu.data >
                    <template #button>
                        <div class="hidden md:block">
                            <ButtonTambah @click="tambahData">Tambah</ButtonTambah>
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
                </card>
            </div>

{{ formmenu["menu"] }}
        </div>


    </AdminLayout>
    <Modal :show="showModal" @close="closeModal">
        <div class="p-2">
            <div class="flex items-start justify-between p-1 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-xl font-semibold">
                    Tambah
                </h3>
            </div>
            <div class="relative p-6 flex-auto animatecss animatecss-fadeInLeft">
                <form @submit.prevent >
                    <div class="grid grid-cols-1 md:grid-cols-1 ">
                        <div class="relative mb-2 animatecss animatecss-fadeInLeft">
                            <InputLabel for="kategori" value="Kategori" class="" />
                            
                            <TextInput
                                id="kategori"
                                ref="kategoriInput"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="nama kategori"
                                v-model="formmenu.kategori"
                            />
                            
                            <p v-if="formmenu.errors.kategori" 
                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                {{formmenu.errors.kategori }}
                            </p>
                        </div>
                    
                        
                    </div>
                    <!-- <div class="relative  animatecss animatecss-fadeInLeft">
                    <InputLabel value="Menu" class="" />
                    </div> -->
                    
                
                                <template v-for="(item, index) in formmenu.menuItem" :key="index" >
                                    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 ">
                                        <div class="relative  ">
                                            <InputLabel value="Menu" class="" />
                                            <div class="relative w-full ">
                                                <TextInput
                                                :id="'menu-' + index"
                                                ref="menuInput"
                                                type="text"
                                                class="mt-1 block w-full"
                                                placeholder="nama menu"
                                                v-model = "item.value"
                                                />
                                                <button   v-on="{ click:  () => tambahAtauHapus(index)  }"
                                                    class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white
                                                    
                                                    rounded-r-lg
                                                    border 
                                                    focus:ring-4 focus:outline-none "
                                                    :class="[index == 0 ? 'bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-blue-300' :
                                                    'bg-red-700 border-red-700 hover:bg-red-800 focus:ring-red-300']">
                                                    <template v-if="index == 0">
                                                    <i class="fas fa-lg fa-plus"></i>
                                                    </template>
                                                    <template v-else="index == 0">
                                                    <i class="fas fa-lg fa-trash-alt"></i>
                                                    </template>
                                                </button>
                                                
                                            </div>
                                            <p v-if="$page.props.errors['menuItem.'+index+'.value']" 
                                                class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{$page.props.errors['menuItem.'+index+'.value']}}
                                            </p>
                                        </div>
                                        <div class="relative  ">
                                                <InputLabel value="Role"  />
                                                    <div class="mt-1 block w-full">
                                                    <Multiselect
                                                        valueProp="id"
                                                        v-model="formmenu.menuItem[index]['role']"
                                                        label="name"
                                                        mode="tags"
                                                        class="mt-1 block w-full"
                                                        @select="(selectedValue) => roleklik(selectedValue,index,1) "
                                                        :searchable="true"
                                                        :options="master[index].role"
                                                        @deselect="(selectedValue) => roleklik(selectedValue,index,0)"
                                                    />
                                                    </div>
                                            </div> 
                                            <div class="relative   ">
                                                <InputLabel value="Permission"  />
                                                <div class="mt-1 block w-full">
                                                    <Multiselect
                                                        valueProp="id"
                                                        v-model="formmenu.menuItem[index]['permission']"
                                                        label="name"
                                                        mode="tags"
                                                        :searchable="true"
                                                        :options="master[index].permission"
                                                    />
                                                    </div>
                                            </div>
                        </div>
                        </template>
                    
                        
                       
                        
                    
                
                
                </form>
            </div>
            
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">
                    Batal
                </SecondaryButton>
                <PrimaryButton class="ml-3" v-on:click="simpan" 
                >
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
</template>

<script>

export default {

    props: {
        listMenu: Object,
        role : Object,
        permission : Object,
        namaRoute:Object

    },
    components:{
        Multiselect
    },
    data() {

        return {
        
            showModal: false,
            dialogHapus:false,
            editMode: false,
            objmenu : null,
            formmenu : this.$inertia.form({
                    kategori: null,
                    menuItem: [
                        { 
                            value: '',
                            role : [],
                            permission : [],
                        },
                    ]
                }),
            master:[
                {
                    role:this.role,
                    permission:this.permission
                },
                
            ]
    
            
        };
    },
    methods: {
        tambahData() {
            this.editMode = false;
            this.objmenu = null;
            this.showModal = !this.showModal;
            this.formmenu.reset()
            this.formmenu.clearErrors()
        },
        closeModal(){
            this.editMode = false;
            this.showModal = !this.showModal;
            this.formmenu.menuItem.splice(1); //hapus semua dari index 1
            this.formmenu.reset();
            this.formmenu.clearErrors()
        },
        roleklik : function(value,i,e) {
            var role = _.filter(this.role, { id: value });
            const permissionIds = _.flatMap(role, 'permissions');
            var targetIds = _.map(permissionIds, 'id');
            // console.log(permissionIds);
            // return false;
                if (e==1) {
                    targetIds.sort((a, b) => b - a); // Urutkan secara menurun untuk menghindari perulangan indeks
                    
                    targetIds.forEach(id => {
                        const index = this.master[i].permission.findIndex(item => item.id === id);
                    
                        // const indexform = this.formmenu.menuItem[i].permission.indexOf(id); //index pada permission pada form
                        if (index !== -1) {
                            this.master[i].permission.splice(index, 1);
                            // this.formmenu.menuItem[i].permission.splice(indexform, 1);
                        }

                    });
                
                }else{
                    permissionIds.forEach(element => {
                        this.master[i].permission.push(element);
                    });
                    this.master[i].permission.sort((a, b) => a.id - b.id);
                
                }

        },

      

        tambahAtauHapus : function(value) {
            if (value == 0) {
                const newField = {
                    value: '',
                    role : [],
                    permission : [],
                };
                const fieldMaster = {
                    
                    role:this.role,
                    permission:this.permission
                };
                this.master.push(fieldMaster);
                this.formmenu.menuItem.push(newField);
            }else{
                this.master.splice(value,1);
                this.formmenu.menuItem.splice(value,1);
            }
        
        },
    
        simpan() {
                if (this.editMode == true) {
                    this.formmenu.put(route('role.update', this.objrole.id), {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            this.showModal = !this.showModal;
                            this.objrole = null;
                            this.formrole.reset();
                        }
                    })

                } else {
                    this.formmenu.post(route('menu.store'), {
                        preserveScroll: true,
                        preserveState: true,
                        onSuccess: () => {
                            this.showModal = !this.showModal;
                            this.objmenu = null;
                            this.formmenu.reset();
                        },
                    })
                }

            },
            hapus(){
                this.formrole.delete(route('role.delete', this.objrole.id), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.dialogHapus = !this.dialogHapus;
                        this.objrole = null;
                    }
                })
            },

    },


};
</script>
<style scoped>
.drop-zone {
    background-color: #eee;
    margin-bottom: 10px;
    padding: 10px;
}

.drag-el {
    background-color: #fff;
    margin-bottom: 10px;
    padding: 5px;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>

