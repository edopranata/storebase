<template>
    <Head><title>Laporan Aset</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Laporan Aset</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid">
            <div class="card w-full rounded-none border-2 border-info shadow-xl">
                <div class="card-body grid md:grid-cols-2 gap-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Kategori</span>
                            </label>
                            <select v-model="form.category_id" class="select select-bordered rounded-none">
                                <option value="">Pilih Kategori</option>
                                <option v-for="item in categories" :value="item.id">{{ item.text }}</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Per Halaman</span>
                            </label>
                            <select v-model="form.per_pages" class="select select-bordered rounded-none">
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Nama Produk</span>
                            </label>
                            <input v-model="form.product_name" class="input input-bordered rounded-none"/>
                        </div>
                    </div>
                    <div class="pt-9 flex space-x-2">
                        <button :disabled="form.processing" type="submit" @click="form.get(route('app.report.stock.index'))" class="btn btn-primary">Tampilkan</button>
                        <a :href="route('app.report.stock.show', 'download')" target="_blank" class="btn btn-secondary">Download All</a>
                        <a :href="route('app.report.stock.show', {stock: 'download', _query: { category_id: form.category_id}})" target="_blank" class="btn btn-secondary">Download Filter</a>
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
                        <th class="py-3 px-6 text-center border-b" colspan="3">Harga Jual</th>
                    </tr>

                    <tr>
                        <th class="py-3 px-6">Gudang</th>
                        <th class="py-3 px-6">Toko</th>
                        <th class="py-3 px-6">Total</th>


                        <th class="py-3 px-6 text-right">Eceran</th>
                        <th class="py-3 px-6 text-right">Pelanggan</th>
                        <th class="py-3 px-6 text-right">Grosir</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="props.products.data.length" v-for="(item, index) in props.products.data">
                        <tr class="hidden" :set="current = {warehouse_stock: item.warehouse_stock ?? 0, store_stock: item.store_stock ?? 0, total_stock: (item.warehouse_stock ?? 0) + (item.store_stock ?? 0)}"></tr>
                        <tr v-for="(price, i) in item.prices" class="hover:cursor-pointer group border-b">
                            <th class="group-hover:bg-base-300 py-4 px-6">{{ (i) ? '' : props.products.from + index }}</th>
                            <td class="group-hover:bg-base-300 py-4 px-6">
                               <div class="badge badge-primary badge-md" v-if="!i">{{ item.barcode }}</div>
                            </td>
                            <td class="group-hover:bg-base-300 py-4 px-6">{{ (i) ? '' : item.name }}</td>

                            <td class="group-hover:bg-base-300 py-4 px-6" :set="warehouse_stock = current.warehouse_stock / price.quantity">{{ Math.floor(warehouse_stock) + ' ' + price.unit.name }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6" :set="store_stock = current.store_stock / price.quantity">{{ Math.floor(store_stock) + ' ' + price.unit.name }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6" :set="total_stock = current.total_stock / price.quantity">{{ Math.floor(total_stock) + ' ' + price.unit.name }}</td>

                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(price.sell_price) }}</td>
                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(price.customer_price) }}</td>

                            <td class="group-hover:bg-base-300 py-4 px-6 text-right">{{ Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(price.wholesale_price) }}</td>

                            <td class="hidden">
                                {{ current.warehouse_stock = current.warehouse_stock - Math.floor(warehouse_stock) }}
                                {{ current.store_stock = current.store_stock - Math.floor(store_stock) }}
                                {{ current.total_stock = current.total_stock - Math.floor(total_stock) }}
                            </td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="9" class="text-center border-b-2">No Data <Link v-if="props.products.current_page > 1" class="link link-primary" :href="route('app.report.asset.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.products.data.length" :links="props.products.links" />
            </div>
        </div>
    </section>

</template>

<script setup>
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import Input from "@/Components/Input.vue";

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
        "label": "Stok Produk"
    },
]
const props = defineProps({
    per_pages: String,
    category_id: String,
    product_name: String,
    categories: Array,
    products: Object,
})

const form = useForm({
    per_pages: props.per_pages ?? '',
    category_id: props.category_id ?? '',
    product_name: props.product_name ?? '',
})
</script>
