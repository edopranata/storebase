<template>
    <Head title="Beranda" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Beranda</PageTitle>
    <section class="px-4 flex flex-wrap gap-4">

    </section>

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";

const breadcrumbs = [
    {
        "url": null,
        "label": "Dashboard"
    }
]
</script>
