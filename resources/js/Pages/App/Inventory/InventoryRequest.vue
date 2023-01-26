<template>
    <Head><title>Inventory Product</title></Head>
    <Breadcrumb :links="breadcrumbs"/>
    <PageTitle :classes="'bg-base-content'" class="">Inventory Product</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid">
            <div class="card w-full rounded-none border-2 border-info shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Tanggal</span>
                            </label>
                            <div class="flex">
                                <button :disabled="props.purchases" class="btn btn-info rounded-none" @click="setToday" >Hari Ini</button>
                                <input type="date" :disabled="props.purchases"  v-model="formInventory.invoice_date" class="input input-bordered rounded-none w-full"/>
                            </div>
                            <div v-if="formInventory.errors.invoice_date" class="text-sm text-error">{{ formInventory.errors.invoice_date }}</div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Supplier</span>
                            </label>
                            <Multiselect :disabled="props.purchases" class="select select-bordered rounded-none focus:ring-0"
                                v-model="formInventory.supplier_id"
                                placeholder="Cari Supplier"
                                :filter-results="false"
                                :min-chars="1"
                                :resolve-on-load="false"
                                :delay="0"
                                :searchable="true"
                                :options="async function(query) {
                                    return await getSuppliers(query) // check JS block for implementation
                                }"
                            />
                            <div v-if="formInventory.errors.supplier_id" class="text-sm text-error">{{ formInventory.errors.supplier_id }}</div>

                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Invoice Number</span>
                            </label>
                            <input :disabled="props.purchases" v-model="formInventory.invoice_number" class="input input-bordered rounded-none"/>
                            <div v-if="formInventory.errors.invoice_number" class="text-sm text-error">{{ formInventory.errors.invoice_number }}</div>
                        </div>
                        <div class="form-control w-full">
                            <button type="button" @click="prosesInventory" class="mt-9 btn">Proses</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import Multiselect from '@vueform/multiselect'

import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";
import axios from "axios";
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
        "url": null,
        "label": "Inventory Product"
    },
]

const props = defineProps({
    purchases: Object,
})


const formInventory = useForm({
    invoice_date: '',
    supplier_id:'',
    invoice_number:'',
})

const setToday = () => {
    let current = Date.now()
    let today = new Date(current).toJSON().split('T')[0]
    formInventory.invoice_date = today
}

const getSuppliers = async (query) => {
    const response = await axios.post(route('app.request.get.supplier'), {search: query});

    return response.data.map((item) => {
        return { value: item.id, label: item.name.toUpperCase() }
    })
}

const prosesInventory = () => {
    formInventory.post(route('app.inventory.request.store'))
}
</script>
