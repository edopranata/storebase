<template>
    <Head><title>Stock Adjustment</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Stock Adjustment</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid grid-cols-2 gap-2">
            <div class="stats bg-primary text-primary-content">

                <div class="stat">
                    <div class="stat-title">{{ props.details.adjustment.title }}</div>
                    <div class="stat-value">{{Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(props.adj_left) }}</div>
                    <div class="stat-actions">
                        <Link as="button" :href="route('app.management.stock.edit', props.details.adjustment_id)" class="btn btn-sm btn-success">
                            <BaseIcon size="20" :path="mdiArrowLeftBold"/> Back
                        </Link>
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
                    </div>
                </div>
            </div>
        </div>
        <form @submit.prevent="saveAdjustment"></form>
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
            </tr>
            <tr>
                <th class="py-3 px-6">Current</th>
                <th class="py-3 px-6">Adjustment</th>
                <th class="py-3 px-6">Ending</th>
            </tr>
            </thead>

            <tbody>
                <tr v-if="props.stocks.data.length" class="border-b" v-for="(item, index) in props.stocks.data">
                    <th class="py-4 px-6">{{ props.stocks.from + index  }}</th>
                    <td class="py-4 px-6">{{ item.created_at }}</td>
                    <td class="py-4 px-6">{{ item.description }}</td>
                    <td class="py-4 px-6">{{ item.supplier ? item.supplier.name : '' }}</td>
                    <td class="py-4 px-6">{{ item.first_stock }}</td>
                    <td class="py-4">
                        <input v-model="form.id[index]" type="hidden">
                        <input v-model="form.opening_stock[index]" type="text" disabled placeholder="Type here" class="input input-bordered w-full w-32" />
                    </td>
                    <td class="py-4">
                        <input v-model="form.adjustment_stock[index]" @change="endingStock(index, $event.target.value)" type="number" :max="parseInt(item.first_stock) - parseInt(item.available_stock)" :min="parseInt(form.opening_stock[index] * -1)" placeholder="Type here" class="input input-bordered w-full w-32" />
                    </td>
                    <td class="py-4">
                        <input v-model="form.ending_stock[index]" type="text" disabled placeholder="Type here" class="input input-bordered w-full w-32" />
                    </td>
                    <td class="py-4 px-6"><button type="button" class="btn btn-sm btn-primary rounded-none" @click="saveAdjustment(item.id, index)">Adjust</button> </td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-right" colspan="7"><span v-if="dataForm.errors.ending_stock" class="text-sm text-error">{{ dataForm.errors.ending_stock }}</span></td>
                    <td class="py-4" >
                        <input v-model="form.total" type="text" disabled placeholder="Type here" class="input input-bordered w-full w-32" />
                    </td>
                    <td class="py-4 px-6">{{ props.details.product.unit.name }}</td>
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
import { mdiArrowLeftBold } from "@mdi/js";
import {onMounted, watch} from 'vue'
import _, { debounce } from "lodash";
import Input from "@/Components/Input.vue";

const breadcrumbs = [
    {
        "url": route('app.index'),
        "label": "Beranda"
    },
    {
        "url": route('app.management.index'),
        "label": "Product"
    },
    {
        "url": route('app.management.stock.index'),
        "label": "Stock Adjustment"
    },
    {
        "url":  route('app.management.stock.edit', props.details.adjustment_id),
        "label": props.details.adjustment.title
    },
    {
        "url": null,
        "label": "Details Stock"
    },
]
const form = useForm({
    id: [],
    first_stock: [],
    opening_stock: [],
    adjustment_stock: [],
    ending_stock: [],
    total: 0
})

const dataForm = useForm({
    stock_id: '',
    adjustment_stock: '',
    ending_stock: '',

})

const props = defineProps({
    details: Object,
    adj_left: Number,
    stocks: {
        type: Object,
    },
})

onMounted( () => {
    toForm()

    calculate(form.ending_stock)
})

watch(() => _.cloneDeep(form), (current, old) => {
    if(current){
        calculate(current.ending_stock)
    }
})
const saveAdjustment = (stock_id, index) => {
    dataForm.stock_id = stock_id;
    dataForm.ending_stock = form.ending_stock[index]
    dataForm.adjustment_stock = form.adjustment_stock[index]
    dataForm.patch(route('app.management.details.update', props.details.id), {
        onSuccess: () => {
            toForm()
        }
    });
}
const toForm = () => {
    props.stocks.data.forEach(function (item, index){
        form.id[index] = item.id
        form.first_stock[index] = item.first_stock
        form.opening_stock[index] = item.available_stock
        form.adjustment_stock[index] = 0
        form.ending_stock[index] = item.available_stock
    })
}
const calculate = (data) => {
    let total = data.reduce((arr, n) => {
        return arr += n
    }, 0)

    form.total = total
}
const endingStock = (index, value) => {
    let ending_stock = isNaN(parseInt(form.opening_stock[index]) + parseInt(value)) ? form.opening_stock[index] : parseInt(form.opening_stock[index]) + parseInt(value)

    form.ending_stock[index] = ending_stock
}
</script>
