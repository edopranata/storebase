<template>
    <Head><title>Laporan</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Transaksi</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.report.transaction.index')" class="btn btn-outline btn-primary">Laporan Transaksi</Link>
        <Link as="button" :href="route('app.report.recap.index')" class="btn btn-outline btn-primary">Rekap Transaksi</Link>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Asset</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.report.asset.index')" class="btn btn-outline btn-primary">Laporan Asset</Link>
        <Link as="button" :href="route('app.report.stock.index')" class="btn btn-outline btn-primary">Laporan Stok dan Harga Modal Produk</Link>
    </section>

</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";

const breadcrumbs = [
    {
        "url": route('app.index'),
        "label": "Beranda"
    },
    {
        "url": null,
        "label": "Laporan"
    },
]
</script>
