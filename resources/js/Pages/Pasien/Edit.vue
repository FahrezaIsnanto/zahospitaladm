<template>
  <div>
    <Head :title="form.namaPasien" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/pasien">Pasien</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.namaPasien }}
    </h1>
    <trashed-message v-if="pasien.deleted_at" class="mb-6" @restore="restore"> Pasien ini sudah terhapus. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaPasien" :error="form.errors.namaPasien" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Pasien" />
          <text-input v-model="form.alamatPasien" :error="form.errors.alamatPasien" class="pb-8 pr-6 w-full lg:w-1/2" label="Alamat Pasien" />
          <text-input v-model="form.noHp" :error="form.errors.noHp" class="pb-8 pr-6 w-full lg:w-1/2" label="Nomor Hp" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!pasien.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus Pasien</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Pasien</loading-button>
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
    pasien: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        namaPasien: this.pasien.nama_pasien,
        alamatPasien: this.pasien.alamat_pasien,
        noHp: this.pasien.no_hp,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/pasien/${this.pasien.id_pasien}`)
    },
    destroy() {
      if (confirm('Apakah Anda yakin akan menghapus data pasien tersebut?')) {
        this.$inertia.delete(`/pasien/${this.pasien.id_pasien}`)
      }
    },
    restore() {
      if (confirm('Apakah Anda yakin akan mengembalikan data pasien tersebut?')) {
        this.$inertia.put(`/pasien/${this.pasien.id_pasien}/restore`)
      }
    },
  },
}
</script>
