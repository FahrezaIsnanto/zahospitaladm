<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/pendaftaran">
        <icon name="printer" class="mr-2 w-4 h-4" :class="isUrl('pendaftaran') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('pendaftaran') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Pendaftaran</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/pasien">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('pasien') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('pasien') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Pasien</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/klinik">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('klinik') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('klinik') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Klinik</div>
      </Link>
    </div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/dokter">
        <icon name="cheveron-right" class="mr-2 w-4 h-4" :class="isUrl('dokter') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('dokter') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dokter</div>
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
