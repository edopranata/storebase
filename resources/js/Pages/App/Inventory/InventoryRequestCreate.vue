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
                                <input type="date" disabled :value="props.purchases.invoice_date" class="input input-bordered rounded-none w-full"/>
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Supplier</span>
                            </label>
                            <input :disabled="props.purchases" :value="props.purchases.supplier_name" class="input input-bordered rounded-none"/>

                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Invoice Number</span>
                            </label>
                            <input :disabled="props.purchases" :value="props.purchases.invoice_number" class="input input-bordered rounded-none"/>
                        </div>
                        <div class="form-control w-full">
                            <button type="button" @click="cancelInventory" class="mt-9 btn btn-error">Batalkan Transaksi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-4 grid gap-4 mt-4" v-show="props.purchases">
        <div class="grid">
            <div class="card w-full rounded-none border-2 border-info shadow-xl">
                <div class="card-body">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Total Pembayaran</span>
                            </label>
                            <number disabled v-model="form.bill" v-bind="{
                                    decimal: '.',
                                    separator: ',',
                                    prefix: 'Rp ',
                                    masked: false,
                                }"
                                    class="input input-bordered rounded-none" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Jumlah Pembayaran</span>
                            </label>
                            <number v-model="form.payment" v-bind="number" class="input input-bordered rounded-none"/>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Sisa Tagihan</span>
                            </label>
                            <number v-model="form.fund" v-bind="number" :disabled="props.purchases" class="input input-bordered rounded-none"/>
                        </div>
                    </div>
                    <div class="card-actions justify-end mt-4">
                        <Link as="button" :href="route('app.inventory.request.show', props.purchases.id)" class="btn btn-primary">Preview Inventory</Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-4 grid gap-4 mt-4" v-show="props.purchases.details">
        <div class="grid">
            <div class="card w-full rounded-none border-2 border-info shadow-xl">
                <div class="card-body">
                    <div class="min-w-full">
                        <div class="my-2">
                            <div v-if="items.errors.quantity" class="text-sm text-error">{{ items.errors.quantity }}</div>
                            <div v-if="items.errors.product_price_id" class="text-sm text-error">{{ items.errors.product_price_id }}</div>
                            <div v-if="items.errors.buying_price" class="text-sm text-error">{{ items.errors.buying_price }}</div>
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text text-2xl font-bold">Cari Produk (Barcode / Nama Produk)</span>
                            </label>

                            <Combobox v-model="selected">
                                <div class="relative mt-1">
                                    <div class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md sm:text-sm">
                                        <ComboboxInput class="w-full border-2 rounded-lg py-2 pl-3 pr-10 text-3xl leading-5 text-gray-900" @change="query = $event.target.value"/>
                                        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
                                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                        </ComboboxButton>
                                    </div>
                                    <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100" leaveTo="opacity-0" @after-leave="addProduct(selected.id)">
                                        <ComboboxOptions class="absolute z-40 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <div v-if="list.products.length === 0 && query !== ''" class="relative cursor-default select-none py-2 px-4 text-gray-700">
                                                Nothing found.
                                            </div>

                                            <ComboboxOption v-for="person in list.products" as="template" :key="person.id" :value="person" v-slot="{ selected, active }" >
                                                <li class="relative cursor-default select-none py-2 pl-10 pr-4" :class="{'bg-teal-600 text-white': active, 'text-gray-900': !active,}">
                                                    <span class="block truncate" :class="{ 'font-medium': selected, 'font-normal': !selected }">
                                                      {{ person.name }}
                                                    </span>
                                                    <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3" :class="{ 'text-white': active, 'text-teal-600': !active }">
                                                      <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                    </span>
                                                </li>
                                            </ComboboxOption>
                                        </ComboboxOptions>
                                    </TransitionRoot>
                                </div>
                            </Combobox>
                        </div>
                        <table v-if="items.product_price_id.length" class="w-full text-left text-base min-w-4xl">
                            <thead class="text-sm uppercase bg-primary/20">
                            <tr>
                                <th class="py-3 px-6">#</th>
                                <th class="py-3 px-6">Product</th>
                                <th class="py-3 px-6 w-32">Jumlah Beli</th>
                                <th class="py-3 px-6">Satuan</th>
                                <th class="py-3 px-6">Quantity Terkecil</th>
                                <th class="py-3 px-6">Harga Modal</th>
                                <th class="py-3 px-6">Total</th>
                                <th class="py-3 px-6">Hapus</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in list.data.details" class="hover:cursor-pointer group border-b">
                                <td class="group-hover:bg-base-300 py-2 px-4 text-sm">{{ index + 1 }}</td>
                                <td class="group-hover:bg-base-300 py-2 px-4 text-sm">{{ item.product_name }}</td>
                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <number v-model="items.quantity[item.id]" @focusout="updateProduct(item.id)" class="w-32 rounded-md border-gray-300 pl-8 pr-4 text-right focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"  />
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <select v-model="items.product_price_id[item.id]" @change="updateProduct(item.id)" class="mt-1 w-32 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <option v-for="(price, i) in item.product.prices" :value="price.id" :selected="item.product_price_id = price.id">{{ price.unit.name }}</option>
                                    </select>
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <number v-model="items.product_price_quantity[item.id]" v-bind="{
                                    decimal: '.',
                                    separator: ',',
                                    suffix: ' @ ' + item.product.unit.name,
                                    masked: false,
                                }"  class="w-32 rounded-md border-gray-300 pl-8 pr-4 text-right focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"  />
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <div class="tooltip tooltip-success tooltip-left" :data-tip="'Harga beli terakhir ' + lastPrice(item)">
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <number v-model="items.buying_price[item.id]" v-bind="{
                                        decimal: '.',
                                        separator: ',',
                                        prefix: 'Rp ',
                                        masked: false,
                                    }" @focusout="updateProduct(item.id)"  class="w-48 rounded-md border-gray-300 pl-8 pr-4 text-right focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"  />
                                        </div>
                                    </div>
                                </td>

                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <number v-model="items.total[item.id]" v-bind="{
                                    decimal: '.',
                                    separator: ',',
                                    prefix: 'Rp ',
                                    masked: false,
                                }"  class="w-48 rounded-md border-gray-300 pl-8 pr-4 text-right focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"  />

                                </td>
                                <td class="group-hover:bg-base-300 py-2 px-4">
                                    <button type="button" @click="removeProduct(item.id)" class="inline-block rounded-lg bg-red-600 px-2 py-1 text-base font-semibold leading-7 text-white shadow-sm ring-1 ring-red-600 hover:bg-red-700 hover:ring-red-700" >Hapus</button>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import {Head, useForm, Link, router} from '@inertiajs/vue3';
import { number } from '@coders-tm/vue-number-format'
import {onMounted, reactive, watch, ref, computed} from "vue";
import { Combobox, ComboboxInput, ComboboxButton, ComboboxOptions, ComboboxOption, TransitionRoot} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import _, {debounce} from "lodash";
import axios from "axios";

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
        "url": null,
        "label": "Inventory Product"
    },
]

const props = defineProps({
    purchases: Object,
})

const items = useForm({
    product_price_id: [],
    product_price_quantity: [],
    quantity: [],
    buying_price: [],
    total: [],
})

const list = reactive({
    products: [],
    data: props.purchases
})

const form = useForm({
    purchase_id: props.purchases.id,
    bill: '',
    payment: '',
    fund: ''
})

let selected = ref()
let query = ref('')

watch(
    query,
    debounce(function (search) {
        if(search){
            axios.post(
                route('app.request.get.product'),
                { search: search },
                {
                    preserveState: true,
                    replace: true,
                }
            ).then(function (response) {
                list.products = response.data;
            });
        }else{
            list.products = []
        }

    }, 300),
    { deep: true }
);

watch(() => _.cloneDeep(form), (current, old) => {
    if(current){
        form.fund = current.bill - current.payment
    }
})

const addProduct = async (id) => {
    await axios.post(route('app.inventory.request.product.add', props.purchases.id), {
        'product_id': id
    }).then( (response) => {
        list.data = response.data
        setForm(response.data)
    })
}
const removeProduct = async (id) => {
    await axios.delete(route('app.inventory.request.product.delete', id))
        .then( (response) => {
            list.data = response.data
            setForm(response.data)
        })
}

const updateProduct = async (id) => {
    let data = {
        product_price_id: items.product_price_id[id],
        quantity: items.quantity[id],
        buying_price: items.buying_price[id],
    }
    await axios.patch(route('app.inventory.request.product.update', id), data)
        .then( (response) => {
            list.data = response.data
            setForm(response.data)
        })
}

const cancelInventory = () => {
    form.delete(route('app.inventory.request.destroy', props.purchases.id))
}

const setForm = (data) => {
    data.details.forEach( (item, index) => {
        items.product_price_quantity[item.id] = item.product_price_quantity
        items.product_price_id[item.id] = item.product_price_id
        items.quantity[item.id] = item.quantity
        items.buying_price[item.id] = item.buying_price
        items.total[item.id] = item.total
    })

    let total = data.details.reduce((arr, detail) => {
        arr.push(detail.total)
        return (arr)
    }, []);

    form.bill = total.reduce((arr, n) => {
        return arr += n
    }, 0)
}

const lastPrice = (item) => {
    let price = item.product.stocks[item.product.stocks.length - 1]
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0  }).format(price.buying_price)
}

const saveTransaction = () => {

}
onMounted( () => {
    setForm(list.data)
})
</script>
