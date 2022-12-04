<template>
  <div>
    <Head title="Tambah Admin" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin">Admin</Link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaAdmin" :error="form.errors.namaAdmin" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Admin" />
          <text-input v-model="form.username" :error="form.errors.username" class="pb-8 pr-6 w-full lg:w-1/2" label="Username" />
          <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" label="Password" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan Admin</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        namaAdmin: null,
        username: null,
        password: null
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/admin')
    },
  },
}
</script>
