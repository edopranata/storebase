<template>
    <Head><title>Stock Adjustment</title></Head>

    <Breadcrumb :links="breadcrumbs"/>

    <PageTitle :classes="'bg-base-content'" class="">Stock Adjustment</PageTitle>

    <section class="px-4 grid gap-4">
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body">
                <form @submit.prevent="save">
                    <div class="form-control w-full">
                        <label class="label">Adjustment Batch Name</label>
                        <input v-model="form.name" type="text" placeholder="Adjustment Batch Name" class="input input-bordered w-full" />
                        <label class="label" v-if="form.errors.name">
                            <span class="label-text-alt text-error">{{ form.errors.name }}</span>
                        </label>
                    </div>
                    <div class="flex justify-between mt-10">
                        <button :disabled="form.processing" type="submit" class="btn btn-primary" :class="form.processing ? 'loading' : ''">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card w-full rounded-none border-2 border-info shadow-xl">
            <div class="card-body grid grid-cols-3 gap-4">
                <div v-if="props.adjustments" v-for="(item, index) in props.adjustments.data" class="stats bg-primary text-primary-content">
                    <div class="stat">
                        <div class="stat-title">{{ item.title }}</div>
                        <div class="stat-value">{{ item.done }} / {{ item.count }}</div>
                        <div class="stat-actions flex justify-end space-x-4">
                            <button :disabled="item.status" class="btn btn-sm">{{ item.status ? "Done" : "Lanjutkan" }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
</template>

<script setup>
import Breadcrumb from "@/Shared/Breadcrumb.vue";
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
        "label": "Stock Adjustment"
    },
]

const props = defineProps({
    search: String,
    adjustments: {
        type: Object,
        default: null
    },
})

const form = useForm({
    name: ''
})

const save = () => {
    console.log(form.name)
    form.post(route('app.management.stock.store'), {
        onSuccess: () => {

        },
    });
}

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
