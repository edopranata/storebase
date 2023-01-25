<template>
    <Head><title>Product Management</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Product</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <div class="flex justify-between items-center mb-4">
                    <div class="form-control">
                        <input v-model="form_search.search" type="text" placeholder="Search…" class="input input-bordered" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid gap-4">
                <table class="w-full text-left text-base">
                    <thead class="text-sm uppercase bg-primary/20">
                    <tr>

                        <th class="tw-w-[10rem]"></th>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Barcode / Kode</th>
                        <th class="py-3 px-6">Nama Produk</th>
                        <th class="py-3 px-6">Deskripsi / Keterangan</th>
                        <th class="py-3 px-6">Kategori</th>
                        <th class="py-3 px-6">Satuan</th>
                        <th class="py-3 px-6">Stock</th>
                        <th class="py-3 px-6">Dibuat Oleh</th>
                        <th class="py-3 px-6">Dibuat pada</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="props.products.data.length" class="hover:cursor-pointer group border-b" v-for="(item, index) in props.products.data">
                        <th class="group-hover:bg-base-300 py-4 px-6"></th>
                        <th class="group-hover:bg-base-300 py-4 px-6">{{ props.products.from + index  }}</th>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.barcode }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.description }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.category }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.unit }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div>Gudang : {{ item.stock.warehouse ?? 0 }}</div>
                            <div>Toko : {{ item.stock.store ?? 0 }}</div>
                        </td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.created_by }}</td>
                        <td class="group-hover:bg-base-300 py-4 px-6">{{ item.created_at }}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="6" class="text-center border-b-2">No Data <Link v-if="props.products.current_page > 1" class="link link-primary" :href="route('app.management.product.index')">Goto First Page</Link></td>
                    </tr>
                    </tbody>
                </table>
                <Pagination v-if="props.products.data.length" :links="props.products.links" />
            </div>
        </div>
    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import PageTitle from "@/Components/PageTitle.vue";

import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
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
        "url": null,
        "label": "Product"
    },
]

const props = defineProps({
    search: String,
    products: {
        type: Object,
    },
})

const form_search = useForm({
    search: props.search
})

watch(
    form_search,
    debounce(function (value) {
        Inertia.get(
            route('app.management.product.index'),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500),
    { deep: true }
);

</script>
