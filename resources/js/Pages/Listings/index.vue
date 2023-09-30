<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useListingFilter } from '@/Composables/UseListingFilter'
import AppLayout from '@/Layouts/AppLayout.vue';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps'
import { Query } from '@/types/listings'
import SkeletonLoader from '@/Components/SkeletonLoader.vue';
import { computed } from 'vue'

const props = defineProps(['modelValue'])
const emit = defineEmits(['update:modelValue'])

const value = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})


// const props = defineProps<{
//     query: Query
//     modelValue: any
// }>()
const { usePlaces } = useGoogleMaps()
const { locationForm, locationError, locationSubmit, price, priceError, priceSubmit, statusCheckbox, statusForm, updateCheckbox, propertyType, propertySubmit, filteredBy } = useListingFilter()

const activeGrid = ref('grid')
// if (props.query?.location !== null) {
//     locationForm.location = props.query?.location
// }
// const local = ref('')
// statusForm.status = props.query?.status
// propertyType.value = props.query?.property_type
// price.value.min = props.query?.price.min
// price.value.max = props.query?.price.max

onMounted(() => {
    const locationInput = <HTMLInputElement>document.getElementById('location')
    usePlaces(locationInput, locationInput.value)

})


</script>

<template>
    <Head title="Listings" />
    <AppLayout>
        <section class="min-h-screen w-screen overflow-x-hidden relative bg-gray-200">
            <div class="grid md:grid-cols-[25%_75%] grid-cols-1 gap-4 pb-8">
                <div class="fixed top-0 left-0 h-screen md:w-1/4 w-5/6 shadow-md bg-white px-8 pt-28 pb-8 overflow-y-auto">
                    <div class="">
                        <h2 class="capitalize font-bold text-2xl mb-4">location</h2>
                        <label for="location" class="sr-only">location</label>
                        <div class="flex gap-3">
                            <input v-model="value" :class="locationError ? 'border-red-500' : ''" type="text" name=""
                                id="location" placeholder="Type your town, region">
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
                <div class="md:col-start-2 md:col-end-3">
                    <div class="w-5/6 mx-auto bg-white mt-8 p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="capitalize font-bold">
                                applied filters
                            </h3>
                            <div class="flex gap-3 items-center">
                                <div class="relative">
                                    <button type="button" title="sort by"
                                        class="flex gap-1 bg-gray-300 py-1 px-3 rounded items-center">
                                        <span class="capitalize">sort by</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>

                                <button @click="activeGrid = 'grid'" type="button" title="Display each item in grid"
                                    class="rounded w-7 h-7 group">
                                    <span class="grid grid-cols-3 grid-rows-3 h-full w-full items-center justify-center">
                                        <template v-for="item in 9">
                                            <span class="w-1.5 aspect-square rounded-full group-hover:bg-blue-500"
                                                :class="[activeGrid === 'grid' ? 'bg-blue-500' : 'bg-dark-blue']"></span>
                                        </template>
                                    </span>
                                </button>
                                <button @click="activeGrid = 'tiles'" type="button" title="Display each item in tiles"
                                    class="rounded w-7 h-7 group">
                                    <span
                                        class="grid grid-cols-[25%_75%] grid-rows-3 h-full w-full items-center justify-center">
                                        <template v-for="item in 6">
                                            <span class="w-1 h-1 rounded-full even:w-5/6 even:h-0.5 group-hover:bg-blue-500"
                                                :class="[activeGrid === 'tiles' ? 'bg-blue-500' : 'bg-dark-blue']"></span>
                                        </template>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <button></button>
                        </div>
                    </div>
                    <p>{{ value }}</p>

                    <div class="px-8 mt-8 grid transition-all w-[90%] mx-auto grid-cols-1  gap-3"
                        :class="[activeGrid === 'grid' ? 'grid-cols-3' : 'grid-cols-2']">
                        <template v-for="cards in 24">
                            <div class="w-full h-80 bg-slate-300 shadow">
                                <SkeletonLoader class="w-full h-5/6 bg-slate-300" />
                                <SkeletonLoader class="w-5/6 h-8 mx-auto bg-slate-400" />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped></style>