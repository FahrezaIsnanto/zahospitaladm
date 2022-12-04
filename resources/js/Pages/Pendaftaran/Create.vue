<template>
  <div>
    <Head title="Tambah Pendaftaran" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin">Pendaftaran</Link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <date-input v-model="form.tanggalPeriksa" :error="form.errors.tanggalPeriksa" class="pb-8 pr-6 w-full lg:w-1/2" label="Tanggal Periksa" />
          <select-input v-model="form.pasien" :error="form.errors.pasien" class="pb-8 pr-6 w-full lg:w-1/2" label="Pasien">
            <option :value="null" />
            <option v-for="pasien in pasienOpsi" :key="pasien.id_pasien" :value="`${pasien.id_pasien}`">{{pasien.nama_pasien}}</option>
          </select-input>
          <select-input v-model="form.klinik" :error="form.errors.klinik" class="pb-8 pr-6 w-full lg:w-1/2" label="Klinik">
            <option :value="null" />
            <option v-for="klinik in klinikOpsi" :key="klinik.id_klinik" :value="`${klinik.id_klinik}`">{{klinik.nama_klinik}}</option>
          </select-input>
          <select-input v-model="form.dokter" :error="form.errors.dokter" class="pb-8 pr-6 w-full lg:w-1/2" label="Dokter">
            <option :value="null" />
            <option v-for="dokter in dokterOpsi" :key="dokter.id_dokter" :value="`${dokter.id_dokter}`">{{dokter.nama_dokter}}</option>
          </select-input>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan Pendaftaran</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import DateInput from '@/Shared/DateInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    DateInput,
  },
  layout: Layout,
  props: {
    pasienOpsi: Object,
    klinikOpsi: Object,
    dokterOpsi: Object
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        tanggalPeriksa: null,
        pasien: null,
        klinik: null,
        dokter: null
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/pendaftaran')
    },
  },
}
</script>
