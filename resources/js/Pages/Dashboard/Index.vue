<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">ZAHOSPITAL ADMIN</h1>
    <p class="mb-8 leading-normal">Selamat datang pada halaman admin pendaftaran zahospital. Dibuat untuk keperluan tugas akhir praktikum SBD 2022. Dibuat oleh <a class="text-indigo-500 hover:text-orange-600 underline" href="https://fahrezaisnanto.com">Fahreza Isnanto</a> :).</p>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
  },
  layout: Layout,
}
</script>
