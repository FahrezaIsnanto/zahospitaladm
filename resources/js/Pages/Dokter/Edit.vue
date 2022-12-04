<template>
  <div>
    <Head :title="form.namaDokter" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/dokter">Dokter</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.namaDokter }}
    </h1>
    <trashed-message v-if="dokter.deleted_at" class="mb-6" @restore="restore"> Dokter ini sudah terhapus. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaDokter" :error="form.errors.namaDokter" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Dokter" />
          <text-input v-model="form.spesialis" :error="form.errors.spesialis" class="pb-8 pr-6 w-full lg:w-1/2" label="Spesialis" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!dokter.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus Dokter</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Dokter</loading-button>
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
    dokter: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        namaDokter: this.dokter.nama_dokter,
        spesialis: this.dokter.spesialis
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/dokter/${this.dokter.id_dokter}`)
    },
    destroy() {
      if (confirm('Apakah Anda yakin akan menghapus data dokter tersebut?')) {
        this.$inertia.delete(`/dokter/${this.dokter.id_dokter}`)
      }
    },
    restore() {
      if (confirm('Apakah Anda yakin akan mengembalikan data dokter tersebut?')) {
        this.$inertia.put(`/dokter/${this.dokter.id_dokter}/restore`)
      }
    },
  },
}
</script>
