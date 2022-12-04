<template>
  <div>
    <Head :title="form.namaAdmin" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/admin">Admin</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.namaAdmin }}
    </h1>
    <trashed-message v-if="admin.deleted_at" class="mb-6" @restore="restore"> Admin ini sudah terhapus. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaAdmin" :error="form.errors.namaAdmin" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Admin" />
          <text-input v-model="form.username" :error="form.errors.username" class="pb-8 pr-6 w-full lg:w-1/2" label="Username" />
          <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" label="Password" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!admin.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Hapus Admin</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Admin</loading-button>
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
    admin: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        namaAdmin: this.admin.nama_admin,
        username: this.admin.username,
        password: null
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/admin/${this.admin.id_admin}`)
    },
    destroy() {
      if (confirm('Apakah Anda yakin akan menghapus data admin tersebut?')) {
        this.$inertia.delete(`/admin/${this.admin.id_admin}`)
      }
    },
    restore() {
      if (confirm('Apakah Anda yakin akan mengembalikan data admin tersebut?')) {
        this.$inertia.put(`/admin/${this.admin.id_admin}/restore`)
      }
    },
  },
}
</script>
