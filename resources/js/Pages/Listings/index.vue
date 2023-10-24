<script setup lang="ts">
import { ref, onMounted, watch, computed, onUnmounted, } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import { useListingFilter } from '@/Composables/UseListingFilter'
import AppLayout from '@/Layouts/AppLayout.vue';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps'
import { Query, Listings, metaLinks } from '@/types/listings'
import Card from '@/Components/Card.vue';



const props = defineProps<{
    query: Query,
    listings: Listings
}>()
const per_page = ref('16')
const { usePlaces, inputValue } = useGoogleMaps()
const { locations, locationError, locationSubmit, price, priceError, statusCheckbox, status, updateCheckbox, propertyType, priceSubmit, propertySubmit, form, setInputsValues } = useListingFilter()

const sidebarToggled = ref(false)
const appliedFilter = ref(false)
const activeGrid = ref('grid')

if (Object.keys(form).length > 0) {
    appliedFilter.value = true
}
watch(inputValue, (newVal) => {

    locations.value = newVal
})

const filter = computed(() => {
    const filArr = Object.values(form)
    const arr = <string[]>[]
    filArr.forEach((item: any | string) => {
        if (item.includes('|')) {
            const ele = item.split('|')
            ele.forEach((element: any) => {
                arr.push(element)
            })
        } else {
            arr.push(item)
        }
    })
    return arr
})
const metaLinks = computed((): metaLinks[] => {
    const arr = ref(<metaLinks[]>[])
    const links = props.listings.meta.links
    let index = ref(1)
    while (index.value < links.length - 1) {
        const element = links[index.value] as metaLinks
        arr.value.push(element)
        index.value++
    }

    return arr.value
})

function removeFilter(e: any) {

    const item = e.currentTarget.textContent as string;
    for (const [key, value] of Object.entries(form)) {
        const newKey = key as keyof typeof form
        if (key === 'location') {
            inputValue.value = ''
            locations.value = ''
        }
        if (item === value) {
            delete form[newKey]
            router.get('/listings', form)
        } else if (value.includes(item)) {
            const val = form[newKey] as string
            const indexofStr = val.indexOf(item)
            if (indexofStr === 0) {
                const str = item + "|"
                const newValue = val.replace(str, '')
                form[newKey] = newValue
                router.get('/listings', form)

            } else {
                const str = "|" + item
                const newValue = val.replace(str, '')
                form[newKey] = newValue
                router.get('/listings', form)
            }

        }
    }


}

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
const search = location.search
const pageInclude = search.includes('page=')
const startQuery = search.startsWith('?page=')
const pageIndex = search.indexOf('&page')
const pageReplace = search.slice(pageIndex)
const newSearch = search.replace(pageReplace, '')
function pageQery(pageNumber: string) {
    if (search.length > 0 && startQuery) {
        router.get('/listings?' + 'page='.concat(pageNumber))
    } else if (search.length > 0 && !pageInclude) {
        router.get('/listings' + search + '&page='.concat(pageNumber))
    } else if (search.length > 0 && pageInclude && !startQuery) {
        router.get('/listings' + newSearch + '&page='.concat(pageNumber))
    }
    else {
        router.get('/listings?' + 'page='.concat(pageNumber))
    }
}
function paginatePrev() {
    const prevPage = props.listings.meta.current_page - 1
    pageQery(prevPage.toString())
}
function paginateNext() {
    const nextPage = props.listings.meta.current_page + 1
    pageQery(nextPage.toString())
}
function specificPage(ev: MouseEvent) {
    const button = ev.target as HTMLButtonElement
    const page = button.textContent!
    pageQery(page)
}
onMounted(() => {
    const locationInput = <HTMLInputElement>document.getElementById('location')
    usePlaces(locationInput, locations.value)
    setInputsValues(props.query?.location, props.query?.status, props.query.price.min, props.query.price.max, props.query.property_type)
})
onUnmounted(() => {
    locations.value = ''
    for (const [key, value] of Object.entries(form)) {
        const newKey = key as keyof typeof form
        if (key) {
            delete form[newKey]
        }
    }
})


</script>

<template>
    <Head title="Listings" />
    <AppLayout>
        <section class="min-h-screen w-full overflow-x-hidden relative bg-gray-200"
            :class="[sidebarToggled ? 'sidebar' : '']">
            <div class="grid lg:grid-cols-[25%_75%] grid-cols-1 -md:gap-4">
                <div class="-lg:fixed z-40 top-0 left-0 -lg:h-screen -lg:w-5/6 shadow-md bg-white px-8 -lg:pt-28 pb-8 -lg:overflow-y-auto transition-transform "
                    :class="[sidebarToggled ? '-lg:translate-x-0' : '-lg:-translate-x-full']">
                    <div class="">
                        <h2 class="capitalize font-bold text-2xl mb-4">location</h2>
                        <label for="location" class="sr-only">location</label>
                        <div class="flex gap-3">
                            <input @keydown="submitLocation" v-model="locations"
                                :class="locationError ? 'border-red-500' : ''" type="text" name="" id="location"
                                placeholder="Type your town, region">
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
                                    <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="status"
                                        value="any" type="radio" id="status-all">
                                    <input type="checkbox" value="any" v-model="statusCheckbox"
                                        class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox checked:bg-accent">
                                </div>
                                <label for="status-all" class="capitalize"> any</label>
                            </div>
                            <div class="flex gap-3 items-center h-full">
                                <div class="relative">
                                    <input tabindex="-1" class="opacity-0" @change="updateCheckbox" v-model="status"
                                        value="rent" type="radio" id="status-rent">
                                    <input type="checkbox" value="rent" v-model="statusCheckbox"
                                        class="absolute inset-0 top-1/2 -translate-y-1/2 -z-10 checkbox checked:bg-accent">
                                </div>

                                <label for="status-rent" class="capitalize"> rent</label>
                            </div>
                            <div class="flex gap-3 items-center h-full">

                                <div class="relative">
                                    <input @change="updateCheckbox" v-model="status" value="sale" type="radio"
                                        id="status-sale" tabindex="-1" class="opacity-0">
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
                <div>
                    <div class="w-[90%] mx-auto">
                        <div class=" w-full bg-white mt-8 p-4">
                            <div class="flex relative -md:justify-end justify-between items-center">
                                <h3 class="capitalize font-bold -md:hidden">
                                    applied filters
                                </h3>
                                <button @click="sidebarToggled = !sidebarToggled"
                                    class=" bg-accent text-white w-12 h-8 rounded-3xl lg:hidden z-50 transition-transform"
                                    :class="[sidebarToggled ? 'fixed right-4' : 'translate-x-0 absolute left-0']">
                                    <span class="relative h-full w-full flex justify-center items-center">
                                        <span class="absolute" :class="[sidebarToggled ? 'opacity-0' : 'opacity-100']">
                                            <i class="fa-solid fa-bars-staggered "></i>
                                        </span>
                                        <span class="absolute" :class="[sidebarToggled ? 'opacity-100' : 'opacity-0']">
                                            <i class="fa-solid fa-xmark "></i>
                                        </span>

                                    </span>
                                </button>
                                <div class="flex gap-3 items-center">
                                    <div>
                                        <label for="per_page">
                                            Per Page
                                        </label>
                                        <select v-model="per_page" name="per page" id="per_page" class="h-8 py-1 rounded">
                                            <option value="16">16</option>
                                            <option value="32">32</option>
                                            <option value="64">64</option>
                                        </select>
                                    </div>
                                    <div class="relative">
                                        <button type="button" title="sort by"
                                            class="flex gap-1 bg-gray-300 py-1 px-3 rounded items-center">
                                            <span class="capitalize">sort by</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>

                                    <button @click="activeGrid = 'grid'" type="button" title="Display each item in grid"
                                        class="rounded w-7 h-7 group">
                                        <span
                                            class="grid grid-cols-3 grid-rows-3 h-full w-full items-center justify-center">
                                            <template v-for="item in 9">
                                                <span class="w-1.5 aspect-square rounded-full group-hover:bg-blue-500"
                                                    :class="[activeGrid === 'grid' ? 'bg-accent' : 'bg-dark-blue']"></span>
                                            </template>
                                        </span>
                                    </button>
                                    <button @click="activeGrid = 'tiles'" type="button" title="Display each item in tiles"
                                        class="rounded w-7 h-7 group">
                                        <span
                                            class="grid grid-cols-[25%_75%] grid-rows-3 h-full w-full items-center justify-center">
                                            <template v-for="item in 6">
                                                <span
                                                    class="w-1 h-1 rounded-full even:w-5/6 even:h-0.5 group-hover:bg-blue-500"
                                                    :class="[activeGrid === 'tiles' ? 'bg-blue-500' : 'bg-dark-blue']"></span>
                                            </template>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex gap-3 mt-3">
                                <template v-for="item in filter">
                                    <button type="button" title="cancel filter" @click="removeFilter"
                                        class="flex items-center text-sm gap-2 rounded-xl bg-blue-500 text-white h-8 px-4">
                                        <span class="">
                                            {{ item }}
                                        </span>
                                        <span
                                            class="h-1/2 aspect-square rounded-full bg-white text-blue-500 flex justify-center items-center">
                                            <i class=" fas fa-xmark fa-sm"></i>
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="mt-8 grid transition-all  gap-3"
                            :class="[activeGrid === 'grid' ? 'grid-cols-4 -md:grid-cols-2 -sm:grid-cols-1 ' : 'grid-cols-1']">
                            <template v-for="(listing) in listings.data">
                                <Link :href="(route('listings.show', listing.id))">
                                <Card class="bg-white relative" :class="[activeGrid === 'tiles' ? 'flex gap-4' : '']">
                                    <div>
                                        <img v-if="listing.listingImage?.length > 0" :src="listing.listingImage[0]" alt=""
                                            class="md:aspect-square"
                                            :class="[activeGrid === 'tiles' ? 'max-w-[200px] -md:max-w-[150px]  -md:h-full object-cover' : '']">
                                        <img v-else src="/Images/no_image_placeholder.jpg" alt=""
                                            :class="[activeGrid === 'tiles' ? 'max-w-[200px] md:aspect-square -md:h-full object-cover -md:max-w-[150px]' : '']">
                                    </div>
                                    <div class="p-4">
                                        <p class="font-bold flex gap-1 mb-3 text-sm text-accent">
                                            <span>
                                                XAF
                                            </span>
                                            <span>

                                                <span v-if="listing.propertyStatus === 'rent'">
                                                    <span>{{ listing.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                                        ",").concat('.00') }}</span>/Month
                                                </span>
                                                <span v-else>
                                                    {{ listing.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                                        ",").concat('.00') }}
                                                </span>
                                            </span>
                                        </p>
                                        <div>
                                            <p v-if="activeGrid === 'grid'" class="font-bold mb-1">
                                                {{ listing.title.slice(0, 35) }}
                                            </p>
                                            <div v-else>
                                                <p class="font-bold mb-1 -md:hidden">
                                                    {{ listing.title }}
                                                </p>
                                                <p class="font-bold mb-1 md:hidden">
                                                    {{ listing.title.slice(0, 35) }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-sm opacity-75 mb-3 capitalize">
                                            {{ listing.propertyType }}
                                        </p>
                                        <hr class="w-full h-[1px] bg-slate-100 mb-3">
                                        <div v-if="activeGrid === 'grid'" class="flex gap-2 text-sm">
                                            <span>
                                                <i class="fas fa-location-dot text-accent"></i>
                                            </span>
                                            <p>{{ listing.location.slice(0, 40) }}</p>
                                        </div>
                                        <div v-else class="flex gap-2 text-sm">
                                            <span>
                                                <i class="fas fa-location-dot text-accent"></i>
                                            </span>
                                            <p class="-md:hidden">{{ listing.location }}</p>
                                            <p class="md:hidden">{{ listing.location.slice(0, 30) }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="capitalize rounded py-1 px-2 absolute top-3 left-3 text-white text-sm cursor-default"
                                        :class="[listing.propertyStatus === 'rent' ? 'bg-green-500' : 'bg-orange-500']">
                                        for {{ listing.propertyStatus }}
                                    </span>
                                </Card>
                                </Link>
                            </template>

                            <!-- <template v-for="cards in 24">
                            <div class="w-full h-80 bg-slate-300 shadow">
                                <SkeletonLoader class="w-full h-5/6 bg-slate-300" />
                                <SkeletonLoader class="w-5/6 h-8 mx-auto bg-slate-400" />
                            </div>
                        </template> -->
                        </div>

                    </div>
                    <div class="flex justify-between md:px-12 px-4 mt-8 bg-white h-20 -md:pb-8 pb-52 lg:pt-16 pt-8">
                        <div class="flex items-center">
                            <button @click="paginatePrev" :disabled="listings.links.prev === null"
                                class="capitalize group border border-accent rounded-full aspect-square w-10"
                                :class="[listings.links.prev === null ? 'opacity-70' : '']">
                                <i class="fas fa-chevron-left transition-transform duration-200 ease-out"
                                    :class="[listings.links.prev !== null ? 'group-hover:-translate-x-1' : '']"></i>
                            </button>
                        </div>
                        <div class="flex gap-2 items-center">
                            <template v-for="(item, index) in metaLinks">
                                <button @click="specificPage"
                                    class="border rounded-full hover:bg-accent-hover hover:text-white transition-colors aspect-square w-10"
                                    :class="[item.active ? 'bg-accent text-white' : '']">
                                    {{ index + 1 }}
                                </button>
                            </template>
                        </div>
                        <div class="flex items-center">
                            <button @click="paginateNext" :disabled="listings.links.next === null"
                                class="capitalize group border border-accent  rounded-full aspect-square w-10"
                                :class="[listings.links.next === null ? 'opacity-70' : '']">
                                <i class="fas fa-chevron-right transition-transform duration-200 ease-out"
                                    :class="[listings.links.next !== null ? 'group-hover:translate-x-1' : '']"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
    .sidebar::before {
        position: absolute;
        content: '';
        inset: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 30;

    }
</style>