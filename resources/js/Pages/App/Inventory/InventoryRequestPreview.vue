<template>
    <Head><title>Inventory Product</title></Head>
    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Inventory Product</PageTitle>

    <section class="px-2 grid gap-4 mt-4">
        <div class="grid">
            <div class="card w-full rounded-none border-2 border-info shadow-xl">
                <div class="card-body">
                    <table class="w-full text-left text-base min-w-4xl">
                        <thead class="text-sm uppercase bg-primary/40">
                        <tr>
                            <th class="py-3 px-6">#</th>
                            <th class="py-3 px-6">Product</th>
                            <th class="py-3 px-6">Jumlah Beli</th>
                            <th class="py-3 px-6">Qty Terkecil</th>
                            <th class="py-3 px-6 text-right">Harga Modal</th>
                            <th class="py-3 px-6 text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="(item, index) in props.purchases.details">
                            <tr class="hover:cursor-pointer">
                                <td class="group-hover:bg-base-300 py-2 px-4">{{ index + 1 }}</td>
                                <td class="group-hover:bg-base-300 py-2 px-4">{{ item.product_name }}</td>
                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    {{ item.quantity + ' ' + item.price.unit.name }}
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    {{ item.product_price_quantity + ' ' + item.product.unit.name }}
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4 text-right">
                                    {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.buying_price) }}
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4 text-right">
                                    {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total) }}
                                </td>
                            </tr>
                            <tr class="text-xs">
                                <td class="bg-primary/20 px-4 text-sm"></td>
                                <td class="bg-primary/20 px-4 text-sm text-right">Supplier</td>
                                <td class="bg-primary/20 px-4 text-sm">Qty Beli</td>
                                <td class="bg-primary/20 px-4 text-sm">Qty Sisa</td>
                                <td class="bg-primary/20 px-4 text-sm text-right">Harga Beli</td>
                                <td class="bg-primary/20 px-4 text-sm text-right">Total</td>
                            </tr>
                            <template v-for="(stock, i) in item.product.stocks">
                                <tr v-if="stock.available_stock" class="text-xs">
                                    <td class="bg-primary/10 px-4 text-sm"></td>
                                    <td class="bg-primary/10 px-4 text-sm text-right"><span>{{ stock.supplier.name }}</span></td>
                                    <td class="bg-primary/10 px-4 text-sm">{{ stock.first_stock }}</td>
                                    <td class="bg-primary/10 px-4 text-sm">{{ stock.available_stock }}</td>
                                    <td class="bg-primary/10 px-4 text-sm text-right">{{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2  }).format(stock.buying_price) }}</td>
                                    <td class="bg-primary/10 px-4 text-sm text-right">{{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 2  }).format(stock.total) }}</td>
                                </tr>
                            </template>

                        </template>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, useForm, Link} from '@inertiajs/vue3';
import Multiselect from '@vueform/multiselect'
import { number } from '@coders-tm/vue-number-format'

import axios from "axios";
import {onMounted, reactive, watch} from "vue";
import _ from "lodash";

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import Button from "@/Components/Button.vue";

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
        "url": route('app.inventory.request.index'),
        "label": "Inventory Product"
    },
    {
        "url": null,
        "label": "Preview"
    },
]

const props = defineProps({
    purchases: Object,
})


const list = reactive({
    data: props.purchases
})

const product = useForm({
    id: ''
})

const form = useForm({
    purchase_id: props.purchases.id,
    bill: '',
    payment: '',
    fund: ''
})

watch(() => _.cloneDeep(product.id), (current, old) => {
    if(current){
        addProduct(current)
    }
})

watch(() => _.cloneDeep(form), (current, old) => {
    if(current){
        form.fund = current.bill - current.payment
    }
})


const setForm = (data) => {
    let total = data.details.reduce((arr, detail) => {
        arr.push(detail.total)
        return (arr)
    }, []);

    form.bill = total.reduce((arr, n) => {
        return arr += n
    }, 0)
}

onMounted( () => {
    setForm(props.purchases)
})
</script>
