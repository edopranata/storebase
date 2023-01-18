<template>
    <Head><title>Inventory</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Inventory</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.inventory.request.index')" class="btn btn-outline btn-primary">Inventory Product</Link>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Inventory Maintenance</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.inventory.maintenance.index')" class="btn btn-outline btn-primary">Inventory Maintenance</Link>
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
        "label": "Inventory"
    },
]
</script>
