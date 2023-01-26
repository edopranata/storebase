<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="Welcome" />

    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Selamat datang</h1>
                <p class="py-6">Untuk akses halaman utama, silahkan login dengan klik tombol dibawah</p>
                <Link :href="route('login')" as="button" class="btn btn-primary">Login</Link>
            </div>
        </div>
    </div>
</template>
