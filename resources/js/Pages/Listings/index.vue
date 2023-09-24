<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useListingFilter } from '@/Composables/UseListingFilter'
import AppLayout from '@/Layouts/AppLayout.vue';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps'
import { Query } from '@/types/listings'


const { usePlaces } = useGoogleMaps()
const { locationForm, locationError, locationSubmit, price, priceError, priceSubmit, statusCheckbox, statusForm, updateCheckbox, propertyType, propertySubmit } = useListingFilter()
const props = defineProps<{
    query: Query
}>()
if (props.query?.location !== null) {
    locationForm.location = props.query?.location
}
statusForm.status = props.query?.status
propertyType.value = props.query?.property_type
price.value.min = props.query?.price.min
price.value.max = props.query?.price.max
onMounted(() => {
    const locationInput = <HTMLInputElement>document.getElementById('location')
    usePlaces(locationInput, locationForm.location)
})
</script>

<template>
    <Head title="Listings" />
    <AppLayout>
        <section class="min-h-screen w-screen overflow-x-hidden relative bg-gray-200">
            <div class="grid grid-20-80">
                <div class="fixed top-0 left-0 h-screen w-1/4 shadow-md bg-white px-8 pt-28 pb-8 overflow-y-auto">
                    <div class="">
                        <h2 class="capitalize font-bold text-2xl mb-4">location</h2>
                        <label for="location" class="sr-only">location</label>
                        <div class="flex gap-3">
                            <input v-model="locationForm.location" :class="locationError ? 'border-red-500' : ''"
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
                                    <input tabindex="-1" class="opacity-0" @change="updateCheckbox"
                                        v-model="statusForm.status" value="all" type="radio" id="status-all">
                                    <input type="checkbox" value="all" v-model="statusCheckbox"
                                        class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox">
                                </div>
                                <label for="status-all" class="capitalize"> all</label>
                            </div>
                            <div class="flex gap-3 items-center h-full">
                                <div class="relative">
                                    <input tabindex="-1" class="opacity-0" @change="updateCheckbox"
                                        v-model="statusForm.status" value="rent" type="radio" id="status-rent">
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
                            <input :class="priceError ? 'border-red-500' : ''" v-model="price.min" placeholder="min"
                                type="text" size="7" name="min" id="price-min">
                            <label for="price-min" class="sr-only"> Minimum price</label>
                            <span>To</span>
                            <input :class="priceError ? 'border-red-500' : ''" v-model="price.max" placeholder="max"
                                size="7" type="text" name="max" id="price-max">
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
                                    class="checkbox" value="room" v-model="propertyType">
                                <label for="property-room" class="capitalize">room</label>
                            </div>
                            <div class="flex gap-2 items-center">
                                <input @change="propertySubmit" type="checkbox" name="studio" id="property-studio"
                                    class="checkbox" value="studio" v-model="propertyType">
                                <label for="property-studio" class="capitalize">studio</label>
                            </div>
                            <div class="flex gap-2 items-center">
                                <input @change="propertySubmit" type="checkbox" name="appartment" id="property-appartment"
                                    class="checkbox" value="appartment" v-model="propertyType">
                                <label for="property-appartment" class="capitalize">appartment</label>
                            </div>
                            <div class="flex gap-2 items-center">
                                <input @change="propertySubmit" type="checkbox" name="duplex" id="property-duplex"
                                    class="checkbox" value="duplex" v-model="propertyType">
                                <label for="property-duplex" class="capitalize">duplex</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div>


                </div>
            </div>
        </section>
    </AppLayout>
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