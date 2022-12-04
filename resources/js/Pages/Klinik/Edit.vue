<template>
  <div>
    <Head :title="form.namaKlinik" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/klinik">Klinik</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.namaKlinik }}
    </h1>
    <trashed-message v-if="klinik.deleted_at" class="mb-6" @restore="restore"> Klinik ini sudah terhapus. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaKlinik" :error="form.errors.namaKlinik" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Klinik" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!klinik.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus Klinik</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Klinik</loading-button>
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
    TrashedMessage,
  },
  layout: Layout,
  props: {
    klinik: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        namaKlinik: this.klinik.nama_klinik
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/klinik/${this.klinik.id_klinik}`)
    },
    destroy() {
      if (confirm('Apakah Anda yakin akan menghapus data klinik tersebut?')) {
        this.$inertia.delete(`/klinik/${this.klinik.id_klinik}`)
      }
    },
    restore() {
      if (confirm('Apakah Anda yakin akan mengembalikan data klinik tersebut?')) {
        this.$inertia.put(`/klinik/${this.klinik.id_klinik}/restore`)
      }
    },
  },
}
</script>
