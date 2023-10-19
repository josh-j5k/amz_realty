<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import Card from '@/Components/Card.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { Listings } from '@/types/listings';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps';
import { useListingFormValidator } from '@/Composables/UseListingFormValidator';
import { useToast } from '@/Composables/UseToast';

const props = defineProps<{
    listings: Listings
}>()
const currentIndex = ref(0)
const { toast } = useToast()
const { usePlaces, inputValue } = useGoogleMaps()
const { valid, formErrors } = useListingFormValidator()
const form = useForm({
    title: props.listings.data[currentIndex.value].title,
    description: props.listings.data[currentIndex.value].description,
    price: <string | number>'',
    location: props.listings.data[currentIndex.value].location,
    property_status: props.listings.data[currentIndex.value].property_status,
    property_type: props.listings.data[currentIndex.value].property_type,
})
form.price = props.listings.data[currentIndex.value].price


const mainImage = ref(0)

const show = ref(false)
const show_delete_warning = ref(false)
const show_edit_modal = ref(false)
const closeable = ref(true)
function closeModal() {
    show.value = false
}
function closeDeleteWarning() {
    show_delete_warning.value = false
}
function showDeleteModal() {
    show.value = false
    show_delete_warning.value = true
}
function closeEditModal() {
    show.value = false
    show_edit_modal.value = false
}

watch(inputValue, newVal => {
    form.location = newVal
})
function showEditModal() {
    show.value = false
    show_edit_modal.value = true
    setTimeout(() => {
        const locationInput = document.getElementById('property_location') as HTMLInputElement
        usePlaces(locationInput, locationInput.value)
    }, 100)
}
function submit() {
    form.put(route('listings.update', props.listings.data[currentIndex.value].id), {
        onSuccess: () => {
            show_edit_modal.value = false
            toast('Success', 'Listing was updated successfully!')
        }
    })
    // form.inputFiles = filesArr.value
    // if (user.value === null) {
    //     return toast('Error', 'You need to be logged in to perform this action')
    // } else if (valid()) {
    //     form.post(route('listings.index'), {
    //         preserveScroll: true,
    //         onSuccess: () => {
    //             toast('Success', 'Listing added successfully')
    //             form.reset()
    //             filesArr.value = <File[]>[]
    //             imgSrc.value = <string[]>[]

    //         }
    //     })
    // }
}

if (show_edit_modal.value === true) {

}

onMounted(() => {
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="pb-12 py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="listings.data.length === 0" class="p-6 text-center text-gray-900">
                        <h2 class="text-2xl mb-4 font-bold">
                            You have no listings
                        </h2>
                        <Link :href="route('listings.create')" class="text-accent">
                        <span>
                            Create your first listing
                        </span>
                        <span>
                            <i class="fas fa-circle-arrow-right"></i>
                        </span>
                        </Link>
                    </div>
                    <div v-else class="p-6 text-gray-900 gap-8 lg:grid grid-cols-[45%_55%]">
                        <div class="">
                            <template v-for="(listing, index) in listings.data">
                                <Card class="bg-white relative flex gap-4 cursor-pointer -lg:hidden">
                                    <div>
                                        <img v-if="listing.listing_image?.length > 0" :src="listing.listing_image[0]" alt=""
                                            class="max-w-[200px] h-full object-cover -md:max-w-[150px]">
                                        <img v-else src="/images/no_image_placeholder.jpg" alt=""
                                            class="h-full object-cover max-w-[200px] -md:max-w-[150px]">
                                    </div>
                                    <div class="p-4">
                                        <p class="font-bold flex gap-1 mb-3 text-sm text-accent">
                                            <span>
                                                FCFA
                                            </span>
                                            <span>

                                                <span v-if="listing.property_status === 'rent'">
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

                                            <div>

                                                <p class="font-bold mb-1">
                                                    {{ listing.title.slice(0, 35) }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-sm opacity-75 mb-3 capitalize">
                                            {{ listing.property_type }}
                                        </p>
                                        <hr class="w-full h-[1px] bg-slate-100 mb-3">

                                        <div class="flex gap-2 text-sm">
                                            <span>
                                                <i class="fas fa-location-dot text-accent"></i>
                                            </span>

                                            <p class="">{{ listing.location.slice(0, 30) }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="capitalize rounded py-1 px-2 absolute top-3 left-3 text-white text-sm cursor-default"
                                        :class="[listing.property_status === 'rent' ? 'bg-green-500' : 'bg-orange-500']">
                                        for {{ listing.property_status }}
                                    </span>
                                </Card>
                                <Card @click="function () {
                                    currentIndex = index
                                    show = true
                                }" class="bg-white relative flex gap-4 cursor-pointer lg:hidden">
                                    <div>
                                        <img v-if="listing.listing_image" :src="listing.listing_image[0]" alt=""
                                            class="max-w-[200px] h-full object-cover -md:max-w-[150px]">
                                        <img v-else src="/images/no_image_placeholder.jpg" alt=""
                                            class="h-full object-cover max-w-[200px] -md:max-w-[150px]">
                                    </div>
                                    <div class="p-4">
                                        <p class="font-bold flex gap-1 mb-3 text-sm text-accent">
                                            <span>
                                                FCFA
                                            </span>
                                            <span>

                                                <span v-if="listing.property_status === 'rent'">
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

                                            <div>

                                                <p class="font-bold mb-1">
                                                    {{ listing.title.slice(0, 35) }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-sm opacity-75 mb-3 capitalize">
                                            {{ listing.property_type }}
                                        </p>
                                        <hr class="w-full h-[1px] bg-slate-100 mb-3">

                                        <div class="flex gap-2 text-sm">
                                            <span>
                                                <i class="fas fa-location-dot text-accent"></i>
                                            </span>

                                            <p class="">{{ listing.location.slice(0, 30) }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="capitalize rounded py-1 px-2 absolute top-3 left-3 text-white text-sm cursor-default"
                                        :class="[listing.property_status === 'rent' ? 'bg-green-500' : 'bg-orange-500']">
                                        for {{ listing.property_status }}
                                    </span>
                                </Card>
                            </template>
                        </div>
                        <div class="px-3 -lg:hidden">
                            <h2 class="mb-4 text-2xl font-bold">{{ listings.data[currentIndex].title }}</h2>
                            <div class="grid grid-cols-[70%_30%] gap-3 h-[390]">

                                <img v-if="listings.data[currentIndex].listing_image"
                                    :src="listings.data[currentIndex].listing_image[mainImage]" alt=""
                                    class="row-span-full">
                                <img v-else src="/images/no_image_placeholder.jpg" alt=""
                                    class="w-96 rounded-3xl aspect-square">
                                <div class="flex flex-col gap-3 overflow-y-auto">
                                    <template v-if="listings.data[currentIndex].listing_image"
                                        v-for="(image, index) in listings.data[currentIndex].listing_image">
                                        <img @click="mainImage = index" :src="image" alt=""
                                            class="w-[124px] aspect-square object-cover rounded-xl">
                                    </template>
                                    <template v-else v-for="(image, index) in 3">
                                        <img src="/images/no_image_placeholder.jpg" alt=""
                                            class="w-[124px] aspect-square object-cover rounded-xl">
                                    </template>
                                </div>
                            </div>
                            <p class="mt-3 text-gray-500 flex gap-3 ">
                                <span>
                                    <i class="fas fa-location-dot"></i>
                                </span>
                                <span>
                                    {{ listings.data[currentIndex].location }}
                                </span>
                            </p>
                            <hr class="w-full h-[1px] bg-gray-200 my-4">
                            <p class="font-bold mb-2 ">
                                Property details
                            </p>
                            <p class="text-gray-700 ">
                                {{ listings.data[currentIndex].description }}
                            </p>
                            <div class="flex justify-between mt-3">
                                <button @click="showEditModal" class="flex flex-col items-center">
                                    <span class=" text-accent text-xl">
                                        <i class="fas fa-pen-to-square"></i>
                                    </span>
                                    <span class="uppercase">
                                        edit listing
                                    </span>
                                </button>
                                <button @click="showDeleteModal" class="flex flex-col items-center">
                                    <span class=" text-red-500 text-xl">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="uppercase">
                                        delete listing
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="show_edit_modal" @close="closeEditModal">
            <div class="p-8">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="flex flex-col gap-4">

                        <p v-if="formErrors.fileError" class="text-red-500"> Please upload at least one photo.</p>
                        <div class="flex flex-col">
                            <label for="listing_title" class="capitalize font-bold text-lg mb-3">listing title</label>
                            <input v-model="form.title" type="text" name="listing title" id="listing_title"
                                placeholder="Enter listing title" class="rounded-md"
                                :class="[formErrors.titleError ? 'border-red-500' : '']">
                        </div>
                        <p v-if="formErrors.titleError" class="text-red-500">
                            Please fill the title field.
                        </p>
                        <div class="flex flex-col">
                            <label for="property_status" class="capitalize font-bold text-lg mb-3">property
                                status</label>
                            <select v-model="form.property_status" name="property status" id="proptery-status"
                                class="rounded-md">
                                <option disabled> Choose property status</option>
                                <option value="rent">For Rent</option>
                                <option value="sale">For Sale</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="price_per_month" class="capitalize font-bold text-lg mb-3">price per
                                month</label>
                            <div class="relative">
                                <input v-model="form.price" type="text" name="listing price" id="price_per_month"
                                    placeholder="Enter the price per month" class="px-14 w-full rounded-md"
                                    :class="[formErrors.priceError ? 'border-red-500' : '']">
                                <span class="font-bold absolute left-2 top-1/2 text-secondary -translate-y-1/2">FCFA</span>
                            </div>
                            <p v-if="formErrors.priceError" class="text-red-500">
                                Please enter a valid price.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <label for="property_location" class="capitalize font-bold text-lg mb-3">property
                                location</label>
                            <input v-model="form.location" type="text" name="location location" id="property_location"
                                placeholder="Enter the property location" class="rounded-md"
                                :class="[formErrors.locationError ? 'border-red-500' : '']">
                        </div>
                        <p v-if="formErrors.locationError" class="text-red-500">
                            Please enter a valid location.
                        </p>
                        <div class="flex flex-col">
                            <label for="property_type" class="capitalize font-bold text-lg mb-3">property
                                type</label>
                            <select v-model="form.property_type" name="property type" id="proptery-type" class="rounded-md"
                                :class="[formErrors.propertyTypeError ? 'border-red-500' : '']">
                                <option disabled> Choose property type</option>
                                <option value="room">Room</option>
                                <option value="studio">Studio</option>
                                <option value="appartment">Appartment</option>
                                <option value="duplex">Duplex</option>
                            </select>
                        </div>
                        <p v-if="formErrors.propertyTypeError" class="text-red-500">
                            Please chose a property type
                        </p>
                        <div class="flex flex-col">
                            <label for="property_description" class="capitalize font-bold text-lg mb-3">property
                                description</label>
                            <textarea v-model="form.description" name="property_description" id="" cols="30" rows="10"
                                class="rounded-md"
                                :class="[formErrors.descriptionError ? 'border-red-500' : '']"></textarea>
                        </div>
                        <p v-if="formErrors.descriptionError" class="text-red-500">
                            Please enter a description.
                        </p>
                        <button type="submit" class="bg-accent py-3 px-6 text-white"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
        <Modal :show="show_delete_warning" @close="closeDeleteWarning" max-width="sm">
            <div class="p-8">
                <p class="flex justify-center items-center gap-3 mb-4">
                    <span class="w-8 h-8 flex justify-center items-center rounded-full bg-gray-200 text-xl">
                        <i class="fas fa-exclamation"></i>
                    </span>
                    <span>
                        Are you sure you want to delete listing?
                    </span>
                </p>
                <div class="flex justify-between">
                    <button @click="router.delete(route('listings.delete', props.listings.data[currentIndex].id))"
                        class="flex gap-2 py-1 px-3 rounded bg-gray-500 text-white">
                        <span>
                            <i class="fas fa-check"></i>
                        </span>
                        <span>
                            Yes
                        </span>
                    </button>
                    <button @click="closeDeleteWarning" class="flex gap-2 py-1 px-3 rounded bg-red-500 text-white">
                        <span>
                            <i class="fas fa-xmark"></i>
                        </span>
                        <span>
                            Cancel
                        </span>
                    </button>
                </div>
            </div>
        </Modal>
        <Modal :show="show" :closeable="closeable" @close="closeModal">
            <div class="p-8 relative">
                <div>
                    <img v-if="listings.data[currentIndex].listing_image"
                        :src="listings.data[currentIndex].listing_image[0]" alt="">
                    <img v-else src="/images/no_image_placeholder.jpg" alt="">
                </div>
                <div>
                    <h2 class="font-bold text-2xl mt-6">
                        {{ listings.data[currentIndex].title }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ listings.data[currentIndex].location }}
                    </p>
                    <p class="text-accent mt-2 mb-6">
                        {{ listings.data[currentIndex].price }}
                    </p>
                    <h3 class="font-bold text-lg mb-3">Description</h3>
                    <p>
                        {{ listings.data[0].description }}
                    </p>
                    <div class="flex justify-between mt-3">
                        <button @click="showEditModal" class="flex flex-col items-center">
                            <span class=" text-accent text-xl">
                                <i class="fas fa-pen-to-square"></i>
                            </span>
                            <span class="uppercase">
                                edit listing
                            </span>
                        </button>
                        <button @click="showDeleteModal" class="flex flex-col items-center">
                            <span class=" text-red-500 text-xl">
                                <i class="fas fa-trash"></i>
                            </span>
                            <span class="uppercase">
                                delete listing
                            </span>
                        </button>
                    </div>
                </div>
                <button @click="closeModal"
                    class="w-8 rounded-full aspect-square bg-gray-600 text-white absolute top-3 right-3">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
