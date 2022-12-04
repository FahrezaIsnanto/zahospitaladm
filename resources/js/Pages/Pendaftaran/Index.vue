<template>
  <div>
    <Head title="Pendaftaran" />
    <h1 class="mb-8 text-3xl font-bold">Pendaftaran</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Dihapus :</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">Semua Data</option>
          <option value="only">Hanya Terhapus</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/pendaftaran/create">
        <span>Tambah</span>
        <span class="hidden md:inline">&nbsp;Pendaftaran</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Tanggal Periksa</th>
            <th class="pb-4 pt-6 px-6">Pasien</th>
            <th class="pb-4 pt-6 px-6">Klinik</th>
            <th class="pb-4 pt-6 px-6">Dokter</th>
            <th class="pb-4 pt-6 px-6">Nomor Antrian</th>
            <th class="pb-4 pt-6 px-6">Dicatat Oleh</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pendaftaran in pendaftaran.data" :key="pendaftaran.id_pendaftaran" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`">
                {{ pendaftaran.tanggal_periksa }}
                <icon v-if="pendaftaran.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                {{ pendaftaran.pasien }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                {{ pendaftaran.klinik }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                {{ pendaftaran.dokter }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                {{ pendaftaran.no_antrian }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                {{ pendaftaran.dicatat_oleh }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/pendaftaran/${pendaftaran.id_pendaftaran}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="pendaftaran.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Belum ada data pendaftaran.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="pendaftaran.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    pendaftaran: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/pendaftaran', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
