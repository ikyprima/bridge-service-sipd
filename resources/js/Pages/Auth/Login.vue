<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
  <Head>
    <title>LOGIN</title>
    <meta name="description" content="Halaman Login APP BPKAD Sumatra Barat">
  </Head>
    <div>
     
      <main>
        <section class="relative w-full h-screen py-40 min-h-screen">
          <div
            class="absolute top-0 w-full h-full bg-blueGray-800 bg-no-repeat bg-full"
            :style="`background-image: url('${registerBg2}');`"
          ></div>
          <div class="container mx-auto px-4 h-full">
    <div class="flex content-center items-center justify-center h-full">
      <div class="w-full lg:w-4/12 px-4">
        <div
          class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-200 border-0"
        >
          <div class="rounded-t mb-0 px-6 py-6">
            <div class="text-center mb-3">
              <h6 class="text-blueGray-500 text-sm font-bold">
                Sign in 
              </h6>
            </div>
           
            <hr class="mt-6 border-b-1 border-blueGray-300" />
          </div>
          <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            
            <form @submit.prevent="submit">
              <div class="relative w-full mb-3">
             
                <InputLabel for="email" class="block uppercase text-blueGray-600 text-xs font-bold mb-2" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />    
                <InputError class="mt-2" :message="form.errors.email" />
              </div>

              <div class="relative w-full mb-3">
                
                <InputLabel for="password"  class="block uppercase text-blueGray-600 text-xs font-bold mb-2" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                  
                    class="mt-1 block w-full border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
               
                <InputError class="mt-2" :message="form.errors.password" />
              </div>
              <div>
                

                <label class="flex items-center">
                    <Checkbox   class="form-checkbox border-0 rounded text-blueGray-700 ml-1 w-5 h-5 ease-linear transition-all duration-150" name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm font-semibold text-blueGray-600">Remember me</span>
                </label>
              </div>

              <div class="text-center mt-6">
                <button
                  class="bg-blueGray-800 text-white active:bg-blueGray-600 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150"
                  type="submit"
                  :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                >
                  Sign In
                </button>

                
               
              </div>
            </form>
          </div>
        </div>
        <div class="flex flex-wrap mt-6 relative">
          <div class="w-1/2">
           
            <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-300 hover:text-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>
          </div>
          
        </div>
      </div>
    </div>
  </div>
    
        </section>
      </main>
    </div>
  </template>

<script>

import Navbar from "@/Components/Navbars/AuthNavbar.vue";
import FooterSmall from "@/Components/Footers/FooterSmall.vue";

import registerBg2 from "@/img/register_bg_2.png";

export default {
  data() {
    return {
      registerBg2,
    };
  },
  components: {
    Navbar,
    FooterSmall,
  },
};
</script>