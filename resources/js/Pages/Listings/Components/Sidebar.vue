<script setup lang="ts">
import { type form } from '@/types/listings'
import { useListingFilter } from '@/Composables/UseListingFilter'
import { ref, Ref } from 'vue';

const { locations, locationError, locationSubmit, price, priceError, statusCheckbox, status, updateCheckbox, propertyType, priceSubmit, propertySubmit } = useListingFilter()

const { sidebarToggled, form } = defineProps<{
    sidebarToggled: boolean,
    form: form,

}>()
const appliedFilter = ref(false)

function submitPrice(ev: KeyboardEvent) {

    if (ev.code === 'Enter' || ev.code === 'NumpadEnter') {
        priceSubmit()
    }
}
function submitLocation(ev: KeyboardEvent) {

    if (ev.code === 'Enter' || ev.code === 'NumpadEnter') {
        locationSubmit()
    }
}
if (Object.keys(form).length > 0) {
    appliedFilter.value = true
}



</script>

<template>
    <div class="-lg:fixed z-40 top-0 left-0 -lg:h-screen -lg:w-5/6 shadow-md bg-white px-8 pt-8 -lg:pt-28 pb-8 -lg:overflow-y-auto transition-transform "
        :class="[sidebarToggled ? '-lg:translate-x-0' : '-lg:-translate-x-full']">
        <div class="">
            <h2 class="capitalize font-bold text-2xl mb-4">location</h2>
            <label for="location" class="sr-only">location</label>
            <div class="flex gap-3">
                <input @keydown="submitLocation" v-model="locations" :class="locationError ? 'border-red-500' : ''"
                    type="text" name="" id="location" placeholder="Type your town, region">
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
                        <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="status" value="any"
                            type="radio" id="status-all">
                        <input type="checkbox" value="any" v-model="statusCheckbox"
                            class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox checked:bg-accent">
                    </div>
                    <label for="status-all" class="capitalize"> any</label>
                </div>
                <div class="flex gap-3 items-center h-full">
                    <div class="relative">
                        <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="status" value="rent"
                            type="radio" id="status-rent">
                        <input type="checkbox" value="rent" v-model="statusCheckbox"
                            class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox checked:bg-accent">
                    </div>

                    <label for="status-rent" class="capitalize"> rent</label>
                </div>
                <div class="flex gap-3 items-center h-full">

                    <div class="relative">
                        <input @change="updateCheckbox" v-model="status" value="sale" type="radio" id="status-sale"
                            tabindex="-1" class="opacity-0">
                        <input type="checkbox" value="sale" v-model="statusCheckbox"
                            class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox checked:bg-accent">
                    </div>
                    <label for="status-sale" class="capitalize"> sale</label>
                </div>
            </div>
        </div>
        <hr class="w-4/5 bg-slate-300 my-8">
        <div>
            <h2 class="capitalize font-bold text-2xl mb-4">Price</h2>
            <div class="flex gap-3 items-center">
                <input @keydown="submitPrice" :class="priceError ? 'border-red-500' : ''" v-model="price.min"
                    placeholder="min" type="text" size="7" name="min" id="price-min">
                <label for="price-min" class="sr-only"> Minimum price</label>
                <span>To</span>
                <input @keydown="submitPrice" :class="priceError ? 'border-red-500' : ''" v-model="price.max"
                    placeholder="max" size="7" type="text" name="max" id="price-max">
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
                    <input @change="propertySubmit" type="checkbox" name="room" id="property-room"
                        class="checkbox checked:bg-accent" value="room" v-model="propertyType">
                    <label for="property-room" class="capitalize">room</label>
                </div>
                <div class="flex gap-2 items-center">
                    <input @change="propertySubmit" type="checkbox" name="studio" id="property-studio"
                        class="checkbox checked:bg-accent" value="studio" v-model="propertyType">
                    <label for="property-studio" class="capitalize">studio</label>
                </div>
                <div class="flex gap-2 items-center">
                    <input @change="propertySubmit" type="checkbox" name="appartment" id="property-appartment"
                        class="checkbox checked:bg-accent" value="appartment" v-model="propertyType">
                    <label for="property-appartment" class="capitalize">appartment</label>
                </div>
                <div class="flex gap-2 items-center">
                    <input @change="propertySubmit" type="checkbox" name="duplex" id="property-duplex"
                        class="checkbox checked:bg-accent" value="duplex" v-model="propertyType">
                    <label for="property-duplex" class="capitalize">duplex</label>
                </div>
            </div>
        </div>
    </div>
</template>