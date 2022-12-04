<template>
  <div>
    <Head title="Tambah Dokter" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/dokter">Dokter</Link>
      <span class="text-indigo-400 font-medium">/</span> Tambah
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.namaDokter" :error="form.errors.namaDokter" class="pb-8 pr-6 w-full lg:w-1/2" label="Nama Dokter" />
          <text-input v-model="form.spesialis" :error="form.errors.spesialis" class="pb-8 pr-6 w-full lg:w-1/2" label="Spesialis" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Simpan Dokter</loading-button>
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
        namaDokter: null,
        spesialis: null
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/dokter')
    },
  },
}
</script>
