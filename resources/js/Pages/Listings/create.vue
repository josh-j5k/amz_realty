<script setup lang="ts">
import FileUpload from '@/Components/FileUpload.vue';
import { useFileUpload } from '@/Composables/UseFileUpload'
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted, watch, computed } from 'vue';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps';
import { useToast } from '@/Composables/UseToast'

const { toast } = useToast()
const { drop, dragenter, dragover, assignFiles, total, imgSrc } = useFileUpload()
const fileError = ref(false)
const userError = ref(false)
const { usePlaces, inputValue } = useGoogleMaps()
const form = useForm({
    title: '',
    property_status: 'rent',
    price: '',
    location: '',
    description: ''

})
const page = usePage()
const user = computed(() => page.props.auth.user)
watch(inputValue, newVal => {
    form.location = newVal
})

function fileUpload(e: MouseEvent) {
    const dropbox = e.currentTarget as HTMLDivElement
    const input = dropbox.querySelector('#file_upload') as HTMLInputElement
    input.click()

}
function submit() {

    if (userError.value === true) {
        return toast('Error', 'You need to be logged in to perform this action')

    } else if (total.value === 0) {
        fileError.value = true
        return setTimeout(() => fileError.value = false, 5000)
    } else {
        form.post(route('listing.index'))
    }
}
function checkAuthenticatedUser() {
    if (user.value === null) {
        userError.value = true
    } else {
        userError.value = false
    }
}
checkAuthenticatedUser()
onMounted(() => {
    const locationInput = document.getElementById('property_location') as HTMLInputElement
    const changeFiles = <any[]>[]
    const dropbox = document.getElementById('dropbox') as HTMLDivElement
    const file_upload = document.getElementById('file_upload') as HTMLInputElement

    assignFiles(file_upload, changeFiles)
    dropbox.addEventListener("dragenter", dragenter, false);
    dropbox.addEventListener("dragover", dragover, false);
    dropbox.addEventListener("drop", function (ev: any) {
        drop(ev, changeFiles, file_upload)
    }, false);
    usePlaces(locationInput, locationInput.value)
    console.log(userError.value);

})

</script>


<template>
    <section
        class="w-screen min-h-screen bg-gray-100 grid grid-cols-[30%_70%] -lg:grid-cols-1 justify-center items-center p-8 gap-4">
        <div
            class="lg:w-[30%] -lg:min-h-screen h-screen overflow-y-auto lg:fixed lg:left-0 mx-auto bg-white shadow px-8 py-12">
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="flex flex-col gap-4">
                    <div>
                        <p class="text-sm mb-2 flex items-center justify-center">
                            <span class="font-bold">
                                Photos <span class="">-></span> {{ total }}/50 -
                            </span>
                            <span>
                                You can add up to 50 photos
                            </span>
                        </p>
                        <FileUpload @file-upload="fileUpload" file_type="image" :file-error="fileError" />
                    </div>
                    <p v-if="fileError" class="text-red-500"> Please upload at least one photo.</p>
                    <div class="flex flex-col">
                        <label for="listing_title" class="capitalize font-bold text-lg mb-3">listing title</label>
                        <input v-model="form.title" type="text" name="listing title" id="listing_title"
                            placeholder="Enter listing title">
                    </div>
                    <p v-if="form.errors.title" class="text-red-500">
                        Please fill the title field.
                    </p>
                    <div class="flex flex-col">
                        <label for="property_status" class="capitalize font-bold text-lg mb-3">property status</label>
                        <select v-model="form.property_status" name="property status" id="proptery-status">
                            <option disabled> Choose property status</option>
                            <option value="rent">For Rent</option>
                            <option value="sale">For Sale</option>
                        </select>
                    </div>
                    <p v-if="form.errors.property_status" class="text-red-500">
                        Please select a proprety status.
                    </p>
                    <div class="flex flex-col">
                        <label for="price_per_month" class="capitalize font-bold text-lg mb-3">price per month</label>
                        <div class="relative">
                            <input v-model="form.price" type="text" name="listing price" id="price_per_month"
                                placeholder="Enter the price per month" class="px-14 w-full">
                            <span class="font-bold absolute left-2 top-1/2 text-secondary -translate-y-1/2">FCFA</span>
                        </div>
                        <p v-if="form.errors.title" class="text-red-500">
                            Please enter a valid price.
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <label for="property_location" class="capitalize font-bold text-lg mb-3">property location</label>
                        <input v-model="form.location" type="text" name="location location" id="property_location"
                            placeholder="Enter the property location">
                    </div>
                    <p v-if="form.errors.title" class="text-red-500">
                        Please enter a valid location.
                    </p>
                    <div class="flex flex-col">
                        <label for="property_description" class="capitalize font-bold text-lg mb-3">property
                            description</label>
                        <textarea v-model="form.description" name="property_description" id="" cols="30"
                            rows="10"></textarea>
                    </div>
                    <p v-if="form.errors.title" class="text-red-500">
                        Please enter a description.
                    </p>
                    <button type="submit" class="bg-accent py-3 px-6 text-white" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Publish
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full h-[90vh] m-auto overflow-hidden bg-white shadow col-start-2 col-end-3 p-4 pb-11">

            <h2 class="font-bold">Preview</h2>
            <div class="lg:grid lg:grid-cols-[60%_40%] h-full w-full border rounded-md">
                <div class="relative w-full h-full overflow-hidden"
                    :class="[imgSrc.length > 0 ? 'bg-black' : 'bg-gray-200']">
                    <div v-if="imgSrc.length > 0">
                        <img :src="imgSrc[0]" alt="" class="max-w-sm h-5/6 object-cover mx-auto">
                        <button type="button" title="click to get previous image"
                            class="w-12 aspect-square rounded-full bg-white absolute left-4 top-1/2 -translate-y-1/2">
                            <span>
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </button>
                        <button type="button" title="click to get next image"
                            class="w-12 aspect-square rounded-full bg-white absolute right-4 top-1/2 -translate-y-1/2">
                            <span>
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </button>
                        <div
                            class="absolute flex gap-2 overflow-x-auto overflow-y-hidden py-1 mx-auto bottom-2 z-10 bg-[rgba(255,_255,_255,_0.7)] justify-center w-full h-16">
                            <template v-for="(item, index) in imgSrc">
                                <img v-if="index > 0" :src="item" alt="" class="w-20 aspect-square object-cover">
                            </template>
                        </div>
                    </div>
                    <div v-else class="flex flex-col text-gray-500 justify-center h-full items-center ">
                        <h2 class="font-bold text-xl capitalize mb-2">
                            your listing preview
                        </h2>
                        <p class="w-4/6 mx-auto text-center">
                            As you create your listing, you can preview it how it is going to appear.
                        </p>
                    </div>
                </div>
                <div class="p-8 overflow-y-auto">
                    <h2 class="font-bold text-xl mb-3">
                        Title
                    </h2>
                    <p class="font-bold">price/month</p>
                    <hr class="w-full h-0.5 bg-slate-300 my-4">
                    <p class="font-bold pb-16">Property location</p>
                    <hr class="w-full h-0.5 bg-slate-300 my-4">
                    <h2 class="font-bold text-lg">
                        Property Description
                    </h2>

                </div>
            </div>

        </div>
        <h2 v-if="userError" class="text-red-500 text center absolute top-2 left-1/2 -translate-x-1/2">
            You need to be an authenticated user to
            publish a
            listing!</h2>
    </section>
</template>