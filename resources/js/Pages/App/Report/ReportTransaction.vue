<template>
    <Head title="Laporan Transaksi" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Transaksi</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid md:grid-cols-2">

        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-2 gap-4">
                <div class="grid md:grid-cols-3">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">User / Kasir</span>
                        </label>
                        <select :disabled="form.processing" v-model="form.user_id" class="select select-info select-bordered">
                            <option value="">Semua User</option>
                            <option v-for="(user, index) in props.users" :value="user.id" :key="index">{{ user.name }}</option>
                        </select>
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Tanggal</span>
                        </label>
                        <input :disabled="form.processing" v-model="form.date" type="date" class="input input-info input-bordered" />
                        <label class="label" v-if="form.errors.year">
                            <span class="label-text-alt text-error">{{ form.errors.year }}</span>
                        </label>
                    </div>
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">&nbsp;</span>
                        </label>
                        <div class="flex space-x-4">
                            <button type="button" class="btn" @click="form.get(route('app.report.transaction.index'), { onSuccess: () => {getTotal()}})">Filter </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body grid gap-4">
                <h4 class="card-title">Transaksi : {{ props.date }}</h4>
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Kasir</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Invoice</th>
                        <th class="py-3 px-6 text-right">Tagihan</th>
                        <th class="py-3 px-6 text-right">Diskon</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6 text-right">Pembayaran</th>
                        <th class="py-3 px-6 text-right">Uang Kembali</th>
                        <th class="py-3 px-6">Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="props.transactions.length" class="" v-for="(item, index) in props.transactions">
                        <tr class="group border-b">
                            <th class="group-hover:bg-base-300 py-2 px-6">{{ 1 + index  }}</th>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.user }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.invoice_date }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.invoice_number }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.bill)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.discount)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.payment)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.refund)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.status }}</td>
                        </tr>
                        <tr v-if="item.returns.length" class="group border-b" v-for="data in item.returns">
                            <td class="group-hover:bg-base-300 py-2 px-6" colspan="3"></td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ data.product_name }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ data.quantity }} x {{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(data.sell_price) }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(0) }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(data.quantity * data.sell_price) }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(0) }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(0) }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">Retur</td>
                        </tr>
                    </template>

                    <tr v-else>
                        <td colspan="10" class="text-center border-b-2">No Data <Link v-if="!props.transactions" class="link link-primary" :href="route('app.report.transaction.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr  class="group border-b">
                        <th colspan="4" class="group-hover:bg-base-300 py-2 px-6 text-right">Total Penjualan</th>
                        <th class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.bill) }}</th>
                        <th class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.discount) }}</th>
                        <th class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.total) }}</th>
                        <th colspan="3" class="group-hover:bg-base-300 py-2 px-6"></th>
                    </tr>
                    <tr  class="group border-b">
                        <th colspan="4" class="group-hover:bg-base-300 py-2 px-6 text-right">Total retur</th>
                        <th colspan="3" class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.sum_return) }}</th>
                        <th colspan="3" class="group-hover:bg-base-300 py-2 px-6"></th>
                    </tr>
                    <tr  class="group border-b">
                        <th colspan="4" class="group-hover:bg-base-300 py-2 px-6 text-right">Total Keseluruhan</th>
                        <th colspan="3" class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.total - balance.sum_return) }}</th>
                        <th colspan="3" class="group-hover:bg-base-300 py-2 px-6"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-body grid gap-4">
                <h4 class="card-title">Transaksi Retur : {{ props.date }}</h4>
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>
                        <th class="py-3 px-6">No</th>
                        <th class="py-3 px-6">Kasir</th>
                        <th class="py-3 px-6">Tanggal</th>
                        <th class="py-3 px-6">Invoice</th>
                        <th class="py-3 px-6 text-right">Quantity Retur</th>
                        <th class="py-3 px-6 text-right">Harga</th>
                        <th class="py-3 px-6 text-right">Total</th>
                        <th class="py-3 px-6">Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="props.returns.length" class="" v-for="(item, index) in props.returns">
                        <tr class="group border-b">
                            <th class="group-hover:bg-base-300 py-2 px-6">{{ 1 + index  }}</th>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.user }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.invoice_date }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.invoice_number }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ item.quantity }}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.sell_price)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(item.total)}}</td>
                            <td class="group-hover:bg-base-300 py-2 px-6">{{ item.status }}</td>
                        </tr>
                    </template>

                    <tr v-else>
                        <td colspan="8" class="text-center border-b-2">No Data <Link v-if="!props.returns" class="link link-primary" :href="route('app.report.transaction.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="6" class="group-hover:bg-base-300 py-2 px-6 text-right">Total Retur</th>
                        <th class="group-hover:bg-base-300 py-2 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.returns)}}</th>
                        <th class="group-hover:bg-base-300 py-2 px-6"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-body grid md:grid-cols-2 gap-4">
                <div></div>
                <div>
                    <table class="w-full text-left text-base">
                        <thead>
                        <tr class="border-b-2 py-2">
                            <th colspan="2">Summaries Transaction</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="border-b">
                            <th width="250">Tanggal Transaksi </th>
                            <td>{{ props.date }}</td>
                        </tr>
                        <tr class="border-b">
                            <th>Total Penjualan</th>
                            <td>{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.total - balance.sum_return) }}</td>
                        </tr>
                        <tr class="border-b">
                            <th>Total Retur Barang</th>
                            <td>{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(balance.returns) }}</td>
                        </tr>
                        <tr class="border-b">
                            <th>Subtotal</th>
                            <td>{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format((balance.total - balance.sum_return) - balance.returns) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import {onMounted, reactive} from "vue";

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";

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
        "label": "Transaksi"
    },
]
const form = useForm({
    date: props.date ? props.date : '',
    user_id: props.user_id ? props.user_id : ''
})

const props = defineProps({
    date: String,
    user_id: String,
    transactions: Array,
    returns: Array,
    users: Array,
})

const balance = reactive({
    total: {
        type: Number,
        default: 0,
    },
    sum_return: {
        type: Number,
        default: 0,
    },
    bill: {
        type: Number,
        default: 0,
    },
    discount: {
        type: Number,
        default: 0,
    },
    returns: {
        type: Number,
        default: 0,
    },
})

onMounted( () =>{
    getTotal()
})

const getTotal = () => {
    let temps = { total: [], bill: [], discount: [], sum_return: [], returns: [] }

    props.transactions.reduce((arr, items) => {
        temps.total.push(items.total)
        temps.bill.push(items.bill)
        temps.discount.push(items.discount)
        temps.sum_return.push(items.sum_return)
        return (temps)
    }, []);


    balance.total = temps.total.reduce((arr, n) => {
        return arr += n
    }, 0)
    balance.sum_return = temps.sum_return.reduce((arr, n) => {
        return arr += n
    }, 0)
    balance.bill = temps.bill.reduce((arr, n) => {
        return arr += n
    }, 0)
    balance.discount = temps.discount.reduce((arr, n) => {
        return arr += n
    }, 0)

    props.returns.reduce((arr, items) => {
        temps.returns.push(items.total)
        return (temps)
    }, []);

    balance.returns = temps.returns.reduce((arr, n) => {
        return arr += n
    }, 0)

}
</script>
