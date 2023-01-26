<template>
    <Head><title>Product Management</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Product</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.management.product.index')" class="btn btn-outline btn-primary">Product Maintenance</Link>
    </section>

    <PageTitle :classes="'bg-base-content'" class="">Stock Maintenance</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">
        <Link as="button" :href="route('app.management.stock.index')" class="btn btn-outline btn-primary">Product Stock Adjustment</Link>
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
        "label": "Product"
    },
]
</script>
