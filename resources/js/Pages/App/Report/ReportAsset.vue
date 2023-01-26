<template>
    <Head title="Laporan Aset" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Aset</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid md:grid-cols-2">
            <div class="stats bg-primary text-primary-content rounded-none">
                <div class="stat">
                    <div class="stat-title">Total Asset</div>
                    <div class="stat-value">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(props.total.balance) }}</div>
                    <div class="stat-desc">Hingga {{ props.position }}</div>
                    <div class="stat-actions flex justify-end">
                        <a class="btn btn-sm btn-outline btn-warning" href="#" onclick="window.open(route('app.report.asset.show', 'download'), '_blank')">Download</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6" rowspan="2">#</th>
                        <th class="py-3 px-6" rowspan="2">Barcode</th>
                        <th class="py-3 px-6" rowspan="2">Nama Barang</th>
                        <th class="py-3 px-6 text-center border-b" colspan="3">Stock</th>
                        <th class="py-3 px-6 text-right" rowspan="2">Total</th>
                    </tr>
                    <tr>
                        <th class="py-3 px-6">Gudang</th>
                        <th class="py-3 px-6">Toko</th>
                        <th class="py-3 px-6">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.assets.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.assets.data">
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.assets.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div class="badge badge-primary badge-md" >{{ item.barcode }}</div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>

                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.warehouse_stock + ' ' + item.unit.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.store_stock + ' ' + item.unit.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.store_stock + item.warehouse_stock + ' ' + item.unit.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total_asset)}}</td>

                    </tr>
                    <tr v-else>
                        <td colspan="7" class="text-center border-b-2">No Data <Link v-if="props.assets.current_page > 1" class="link link-primary" :href="route('app.report.asset.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.assets.data.length" :links="props.assets.links" />
            </div>
        </div>
    </section>

</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";

const breadcrumbs = [
    {
        "url": route('app.index'),
        "label": "Beranda"
    },
    {
        "url": route('app.report.index'),
        "label": "Laporan"
    },
    {
        "url": null,
        "label": "Aset"
    },
]

const props = defineProps({
    position: String,
    total: Object,
    assets: Object,
})
</script>
