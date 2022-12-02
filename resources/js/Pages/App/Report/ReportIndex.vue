<template>
    <Head title="Laporan" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laporan</PageTitle>

    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.report.asset.index')" class="btn btn-outline btn-primary">Laporan Asset</Link>
        <Link as="button" :href="route('app.report.transaction.index')" class="btn btn-outline btn-primary">Laporan Transaksi</Link>
    </section>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

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
