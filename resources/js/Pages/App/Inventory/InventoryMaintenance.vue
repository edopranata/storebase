<template>
    <Head><title>Inventory Maintenance</title></Head>
    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Inventory Maintenance</PageTitle>
    <section class="px-4 grid gap-4">
        <div class="grid md:grid-cols-2">

        </div>
    </section>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";

const breadcrumbs = [
    {
        "url": route('app.index'),
        "label": "Beranda"
    },
    {
        "url": route('app.inventory.index'),
        "label": "Inventory"
    },
    {
        "url": null,
        "label": "Maintenance"
    },
]
</script>
