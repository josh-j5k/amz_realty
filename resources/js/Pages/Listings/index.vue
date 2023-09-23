<script setup lang="ts">
import { InertiaForm, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Query } from '@/types/listings'

const props = defineProps<{
    query: Query
}>()

const locationForm = useForm({
    location: props.query?.location
})
const locationError = ref(false)
const priceError = ref(false)
const statusForm = useForm({
    status: props.query?.status
})
const formProperty = useForm({
    property_type: []
})
const price = ref(
    {
        min: props.query?.price.min,
        max: props.query?.price.max,
    }
)
const formPrice = useForm({
    price: ''
})
const searchQuery = location.search
const statusCheckbox = ref([statusForm.status])
function submit(form: any, formValue: string): void {
    const key = Object.keys(form)[0]
    if (searchQuery.length > 0) {
        form.get('/listings'.concat(searchQuery) + `&${key}=`.concat(formValue))
        return
    }
    form.get('/listings')
}
function updateCheckbox() {
    statusCheckbox.value = [statusForm.status]
    submit(statusForm, statusForm.status)
}
function locationSubmit() {
    if (locationForm.location === null || locationForm.location.length === 0) {
        locationError.value = true
        setTimeout(() => locationError.value = false, 4000)
        return
    }
    submit(locationForm, locationForm.location)
}
function setPriceError() {
    priceError.value = true
    setTimeout(() => priceError.value = false, 4000)
    return
}
function priceValidate() {
    const newPriceMin = parseInt(price.value.min)
    const newPriceMax = parseInt(price.value.max)
    if (price.value.min.length === 0 && price.value.max.length === 0) {
        setPriceError()
    } else if (price.value.min.length > 0 && isNaN(newPriceMin)) {
        setPriceError()
    } else if (price.value.max.length > 0 && isNaN(newPriceMax)) {
        setPriceError()
    } else if (newPriceMin > newPriceMax) {
        setPriceError()
    } else {
        return true
    }

}
function priceSubmit() {
    if (priceValidate()) {

        if (price.value.min.length > 0 && price.value.max.length === 0) {
            formPrice.price = formPrice.price + 'min_'.concat(price.value.min)
        }
        if (price.value.max.length > 0 && price.value.min.length === 0) {
            formPrice.price = formPrice.price + 'max_'.concat(price.value.max)
        }
        if (price.value.max.length > 0 && price.value.min.length > 0) {
            formPrice.price = formPrice.price + 'min_'.concat(price.value.min) + '|' + 'max_'.concat(price.value.max)
        }
        const encoded = encodeURI(formPrice.price)
        submit(formPrice, encoded)
    }
}


</script>

<template>
    <section class="min-h-screen w-screen overflow-x-hidden relative bg-gray-200">
        <div class="grid grid-20-80">
            <div class="fixed top-0 left-0 h-screen w-1/4 shadow-md bg-white px-8 pt-24 pb-8 overflow-y-auto">
                <div class="">
                    <h2 class="capitalize font-bold text-2xl mb-4">location</h2>
                    <label for="location" class="sr-only">location</label>
                    <div class="flex gap-3">
                        <input v-model="locationForm.location" :class="locationError ? 'border-red-500' : ''" type="text"
                            name="" id="location" placeholder="Type your town, region">
                        <button @click="locationSubmit" type="button" title="submit location"><i
                                class="fas fa-chevron-right fa-lg"></i></button>
                    </div>
                    <p v-if="locationError" class="text-red-500">Please enter a location</p>
                </div>
                <hr class="w-4/5 bg-slate-300 my-8">
                <div>
                    <h2 class="capitalize font-bold text-2xl mb-4">status</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex gap-3 items-center h-full">
                            <div class="relative">
                                <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="statusForm.status"
                                    value="all" type="radio" id="status-all">
                                <input type="checkbox" value="all" v-model="statusCheckbox"
                                    class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox">
                            </div>
                            <label for="status-all" class="capitalize"> all</label>
                        </div>
                        <div class="flex gap-3 items-center h-full">
                            <div class="relative">
                                <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="statusForm.status"
                                    value="rent" type="radio" id="status-rent">
                                <input type="checkbox" value="rent" v-model="statusCheckbox"
                                    class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox">
                            </div>

                            <label for="status-rent" class="capitalize"> rent</label>
                        </div>
                        <div class="flex gap-3 items-center h-full">

                            <div class="relative">
                                <input @change="updateCheckbox" v-model="statusForm.status" value="sale" type="radio"
                                    id="status-sale" tabindex="-1" class="opacity-0">
                                <input type="checkbox" value="sale" v-model="statusCheckbox"
                                    class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox">
                            </div>
                            <label for="status-sale" class="capitalize"> sale</label>
                        </div>
                    </div>
                </div>
                <hr class="w-4/5 bg-slate-300 my-8">
                <div>
                    <h2 class="capitalize font-bold text-2xl mb-4">Price</h2>
                    <div class="flex gap-3 items-center">
                        <input :class="priceError ? 'border-red-500' : ''" v-model="price.min" placeholder="min" type="text"
                            size="7" name="min" id="price-min">
                        <label for="price-min" class="sr-only"> Minimum price</label>
                        <span>To</span>
                        <input :class="priceError ? 'border-red-500' : ''" v-model="price.max" placeholder="max" size="7"
                            type="text" name="max" id="price-max">
                        <label for="price-max" class="sr-only"> Maximum price</label>
                        <button @click="priceSubmit" title="submit price" type="button"><i
                                class="fas fa-chevron-right fa-lg"></i></button>
                    </div>
                    <p v-if="priceError" class="text-red-500">Please enter a valid price range</p>
                </div>
                <hr class="w-4/5 bg-slate-300 my-8">
                <div>
                    <h2 class="capitalize font-bold text-2xl mb-4">Property type</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" name="room" id="property-room" class="checkbox" value="room"
                                v-model="formProperty.property_type">
                            <label for="property-room" class="capitalize">room</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" name="studio" id="property-studio" class="checkbox" value="studio"
                                v-model="formProperty.property_type">
                            <label for="property-studio" class="capitalize">studio</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" name="appartment" id="property-appartment" class="checkbox"
                                value="appartment" v-model="formProperty.property_type">
                            <label for="property-appartment" class="capitalize">appartment</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" name="duplex" id="property-duplex" class="checkbox" value="duplex"
                                v-model="formProperty.property_type">
                            <label for="property-duplex" class="capitalize">duplex</label>
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>
        </div>
    </section>
</template>

<style scoped>
    .grid-20-80 {
        grid-template-columns: 25% 75%;
    }

    @media (max-width: 769px) {
        .grid-20-80 {
            grid-template-columns: 1fr;
        }
    }
</style>