<template>
    <Head><title>Stock Adjustment</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Stock Adjustment</PageTitle>

    <template>
        <TransitionRoot appear :show="isOpenUpdate" as="template">
            <Dialog as="div" @close="closeModalUpdate" class="relative z-10">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-2xl p-6 text-left alert-warning align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg font-medium font-bold leading-6"
                                >
                                    Update stock
                                </DialogTitle>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-900">
                                        Pastikan pada saat update stock, tidak ada transaksi untuk produk ini.
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <button
                                        type="button"
                                        class="btn btn-primary rounded-none"
                                        @click="updateStock"
                                    >
                                        Update stock
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </template>

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

                        <th class="tw-w-[10rem]" rowspan="2"></th>
                        <th class="py-3 px-6" rowspan="2">#</th>
                        <th class="py-3 px-6" rowspan="2">Barcode / Kode</th>
                        <th class="py-3 px-6" rowspan="2">Nama Produk</th>
                        <th class="py-3 px-6" rowspan="2">Kategori</th>
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
                    <tr v-for="(item, index) in props.products.data" v-if="props.products.data.length" class="hover:cursor-pointer group border-b">
                        <Link as="th" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6"></Link>
                        <Link as="th" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ props.products.from + index  }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.barcode }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.name }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.category }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.stock.total }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.stock.adjust }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.stock.ending }}</Link>
                        <Link as="td" :href="item.status ? 'javascript:;' : route('app.management.details.show', item.id)" class="group-hover:bg-base-300 py-4 px-6">{{ item.unit }}</Link>
                        <td class="group-hover:bg-base-300 py-4 px-6">
                            <div v-if="item.status" class="alert alert-success p-2 shadow-lg rounded-none">
                                <div>
                                    <BaseIcon size="20" :path="mdiCheck"/> Done at {{ item.status }}
                                </div>
                            </div>
                            <span v-if="!item.status">
                                <button v-if="item.stock.adjust !== 0 || item.stock.ending !== 0" @click="formUpdate.id = item.id"  as="button" class="btn rounded-none btn-sm btn-primary shadow-lg">Adjustment</button>
                            </span>
                            <Link v-if="!item.status" as="button"  :href="route('app.management.stock.destroy', item.id)" method="DELETE" class="btn rounded-none btn-sm btn-warning shadow-lg">Cocok</Link>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="10" class="text-center border-b-2">No Data <Link v-if="props.products.current_page > 1" class="link link-primary" :href="route('app.management.stock.edit', props.adjustment.id)">Goto First Page</Link></td>
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
import BaseIcon from "@/Components/BaseIcon.vue";

import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'
import { mdiCheck } from "@mdi/js";
import { watch, ref } from 'vue'
import _, { debounce } from "lodash";
import Button from "@/Components/Button.vue";

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
        "url":  route('app.management.stock.index'),
        "label": "Stock Adjustment"
    },
    {
        "url":  null,
        "label": props.adjustment.title
    },
]

const props = defineProps({
    search: String,
    adjustment: Object,
    products: {
        type: Object,
    },
})

const form_search = useForm({
    search: props.search
})

const formUpdate = useForm({
    id: '',
})
watch(
    form_search,
    debounce(function (value) {
        router.get(
            route('app.management.stock.edit', props.adjustment.id),
            { search: value.search },
            {
                preserveState: true,
                replace: true,
            }
        );
    }, 500),
    { deep: true }
);
watch(() => _.cloneDeep(formUpdate), (current, old) => {
    if(current.id){
        openModalUpdate()
    }
})

const isOpenUpdate = ref(false)

function closeModalUpdate() {
    formUpdate.id = '';
    isOpenUpdate.value = false
}
function openModalUpdate() {
    isOpenUpdate.value = true
}

const updateStock = () => {
    formUpdate.patch(route('app.management.stock.update', formUpdate), {
        onSuccess: () => {
            closeModalUpdate()
        }
    })
}
</script>
