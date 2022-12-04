<template>
  <div>
    <Head title="Tambah Pasien" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/pasien">Pasien</Link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaPasien" :error="form.errors.namaPasien" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Pasien" />
          <text-input v-model="form.alamatPasien" :error="form.errors.alamatPasien" class="pb-8 pr-6 w-full lg:w-1/2" label="Alamat Pasien" />
          <text-input v-model="form.noHp" :error="form.errors.noHp" class="pb-8 pr-6 w-full lg:w-1/2" label="Nomor Hp" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan Pasien</loading-button>
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
        namaPasien: null,
        alamatPasien: null,
        noHp: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/pasien')
    },
  },
}
</script>
