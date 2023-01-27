<template>
    <Head><title>Stock Adjustment</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Stock Adjustment</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid grid-cols-2 gap-2">
            <div class="stats bg-primary text-primary-content">

                <div class="stat">
                    <div class="stat-title">{{ props.details.adjustment.title }}</div>
                    <div class="stat-value">$89,400</div>
                    <div class="stat-actions">
                        <button class="btn btn-sm btn-success">Add funds</button>
                    </div>
                </div>

            </div>

            <div class="stats bg-primary text-primary-content">

                <div class="stat">
                    <div class="stat-title">{{ props.details.product.barcode }} {{ props.details.product.name }}</div>
                    <div class="stat-value">{{ props.details.stocks_sum_available_stock }} {{ props.details.product.unit.name }}</div>
                    <div class="stat-actions flex justify-end space-x-2">
                        <span class="badge p-4 rounded-lg">Gudang {{ props.details.product.warehouse_stock }} {{ props.details.product.unit.name }}</span>
                        <span class="badge p-4 rounded-lg">Toko {{ props.details.product.store_stock }} {{ props.details.product.unit.name }}</span>

<!--                        <button class="btn btn-sm btn-success">Gudang {{ props.details.product.warehouse_stock }} {{ props.details.product.unit.name }}</button>-->
<!--                        <button class="btn btn-sm btn-success">Toko {{ props.details.product.store_stock }} {{ props.details.product.unit.name }}</button>-->
                    </div>
                </div>
            </div>
        </div>

        <table class="w-full text-left text-base">
            <thead class="text-sm uppercase bg-primary/20">
            <tr>
                <th class="py-3 px-6" rowspan="2">#</th>
                <th class="py-3 px-6" rowspan="2">Tanggal</th>
                <th class="py-3 px-6" rowspan="2">Keterangan</th>
                <th class="py-3 px-6" rowspan="2">Supplier</th>
                <th class="py-3 px-6" rowspan="2">Inventory</th>
                <th class="py-3 px-6 text-center border-b-1 border-gray-800" colspan="3">Stock Adjustment</th>
                <th class="py-3 px-6" rowspan="2">Satuan</th>
                <th class="py-3 px-6" rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th class="py-3 px-6">Opening</th>
                <th class="py-3 px-6">Adjustment</th>
                <th class="py-3 px-6">Ending</th>
            </tr>
            </thead>
            <tbody>
                    <tr v-if="props.stocks.data.length" class="border-b" v-for="(item, index) in props.stocks.data">
                        <th class="py-4 px-6">{{ props.stocks.from + index  }}</th>
                        <td class="py-4 px-6">{{ item.created_at }}</td>
                        <td class="py-4 px-6">{{ item.description }}</td>
                        <td class="py-4 px-6">{{ item.supllier ? item.supllier.name : '' }}</td>
                        <td class="py-4 px-6">{{ item.first_stock }}</td>
                        <td class="py-4 px-6">
                            <input type="text" disabled placeholder="Type here" class="input input-bordered w-full w-32" :value="item.available_stock" />
                        </td>
                        <td>
                            <input type="text" placeholder="Type here" class="input input-bordered w-full w-32" />
                        </td>
                        <td>
                            <input type="text" disabled placeholder="Type here" class="input input-bordered w-full w-32" />
                        </td>
                        <td class="py-4 px-6">{{ item.product.unit.name }}</td>
                        <td class="py-4 px-6">

                            <Link v-if="!item.status" as="button" :href="route('app.management.details.show', item.id)" class="btn rounded-none btn-sm btn-primary">Adjustment</Link>
                            <Link v-if="!item.status" as="button" :href="route('app.management.stock.destroy', item.id)" method="DELETE" class="btn rounded-none btn-sm btn-warning">Cocok</Link>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="6" class="text-center border-b-2">No Data <Link v-if="props.stocks.current_page > 1" class="link link-primary" :href="route('app.management.product.index')">Goto First Page</Link></td>
                    </tr>
            </tbody>
        </table>
                <Pagination v-if="props.stocks.data.length" :links="props.stocks.links" />
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import PageTitle from "@/Components/PageTitle.vue";
import BaseIcon from "@/Components/BaseIcon.vue";

import {Head, useForm, Link, router} from '@inertiajs/vue3';
import { mdiCheck } from "@mdi/js";
import { watch } from 'vue'
import { debounce } from "lodash";

const breadcrumbs = [
    {
        "url": route('app.index'),
        "label": "Beranda"
    },
    {
        "url": route('app.management.index'),
        "label": "Management"
    },
    {
        "url": route('app.management.stock.edit', props.details.adjustment_id),
        "label": "Stock Adjustment"
    },
    {
        "url": null,
        "label": "Details Stock"
    },
]

const props = defineProps({
    details: Object,
    stocks: {
        type: Object,
    },
})


</script>
