<template>
    <Head title="Rekapitulasi Transaksi" />

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Rekapitulasi Transaksi</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="grid md:grid-cols-2">

        </div>
        <div class="hidden badge-primary badge-secondary badge badge-accent badge-ghost badge-info badge-error"></div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid md:grid-cols-2 gap-4">
                <div class="grid md:grid-cols-3">
                    <div class="form-control p-1">
                        <label class="label">
                            <span class="label-text">Jenis Laporan</span>
                        </label>
                        <select v-model="form.type" class="select select-info select-bordered">
                            <option value="daily">Harian</option>
                            <option value="monthly">Bulanan</option>
                            <option value="yearly">Tahunan</option>
                        </select>
                    </div>
                    <div class="form-control p-1" v-show="form.type === 'daily'">
                        <label class="label">
                            <span class="label-text">Harian</span>
                        </label>
                        <input :disabled="form.processing" v-model="form.date" type="date" class="input input-info input-bordered" />
                    </div>
                    <div class="form-control p-1" v-show="form.type !== 'daily'">
                        <label class="label">
                            <span class="label-text">Periode</span>
                        </label>
                        <div :class="form.type !== 'yearly' ? 'grid grid-cols-2 gap-2' : 'grid grid-cols-1 gap-2'">
                            <select v-show="form.type === 'monthly'" v-model="form.month" class="select select-info select-bordered">
                                <option value="">Bulan</option>
                                <option v-for="(n, index) in 12" :value="n">{{ n }}</option>
                            </select>

                            <input placeholder="Tahun" :disabled="form.processing" v-model="form.year" type="number" class="input input-info input-bordered" />
                        </div>
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
            </div>
            <div class="card-body grid gap-4">
                <h4 class="card-title">Transaksi Retur : {{ props.date }}</h4>
            </div>
            <div class="card-body grid md:grid-cols-2 gap-4">
                <div></div>
                <div>
                </div>
            </div>
        </div>
    </section>

</template>

<script setup>
import PageTitle from '@/Components/PageTitle.vue'
import Breadcrumb from "@/Shared/Breadcrumb.vue";

import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, watch } from "vue";
import _ from "lodash";

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
        "label": "Rekapitulasi Transaksi"
    },
]

const form = useForm({
    type: 'daily',
    date: '',
    month: '',
    year: '',
})


const props = defineProps({
    date: String,
    user_id: String,
    transactions: Array,
    returns: Array,
    users: Array,
})

onMounted( () =>{

})

watch(() => _.cloneDeep(form.type), (current, old) => {
    if(current){
        form.clearErrors('type', 'date', 'month', 'year');
        form.reset( 'date', 'month', 'year');

        form.defaults({
            date: '',
            month: '',
            year: '',
        })
    }
})
</script>
