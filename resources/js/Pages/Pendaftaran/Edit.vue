<template>
  <div>
    <Head title="Pendaftaran Edit" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/pendaftaran">Pendaftaran</Link>
      <span class="text-indigo-400 font-medium">/</span>
      Edit
    </h1>
    <trashed-message v-if="pendaftaran.deleted_at" class="mb-6" @restore="restore"> Pendaftaran ini sudah terhapus. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
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
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!pendaftaran.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus Pendaftaran</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Pendaftaran</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import DateInput from '@/Shared/DateInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    DateInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    pasienOpsi: Object,
    klinikOpsi: Object,
    dokterOpsi: Object,
    pendaftaran: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        tanggalPeriksa: this.pendaftaran.tanggal_periksa,
        pasien: this.pendaftaran.id_pasien,
        klinik: this.pendaftaran.id_klinik,
        dokter: this.pendaftaran.id_dokter
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/pendaftaran/${this.pendaftaran.id_pendaftaran}`)
    },
    destroy() {
      if (confirm('Apakah Anda yakin akan menghapus data pendaftaran tersebut?')) {
        this.$inertia.delete(`/pendaftaran/${this.pendaftaran.id_pendaftaran}`)
      }
    },
    restore() {
      if (confirm('Apakah Anda yakin akan mengembalikan data pendaftaran tersebut?')) {
        this.$inertia.put(`/pendaftaran/${this.pendaftaran.id_pendaftaran}/restore`)
      }
    },
  },
}
</script>
