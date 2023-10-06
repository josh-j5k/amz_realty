<script setup lang="ts">
import FileUpload from '@/Components/FileUpload.vue';
import { useFileUpload } from '@/Composables/UseFileUpload'
import { ref, onMounted } from 'vue';

const { drop, dragenter, dragover, assignFiles, total, imgSrc } = useFileUpload()


function fileUpload(e: MouseEvent) {
    const dropbox = e.currentTarget as HTMLDivElement
    const input = dropbox.querySelector('#file_upload') as HTMLInputElement
    input.click()

}
onMounted(() => {
    const changeFiles = <any[]>[]
    const dropbox = document.getElementById('dropbox') as HTMLDivElement
    const file_upload = document.getElementById('file_upload') as HTMLInputElement

    assignFiles(file_upload, changeFiles)
    dropbox.addEventListener("dragenter", dragenter, false);
    dropbox.addEventListener("dragover", dragover, false);
    dropbox.addEventListener("drop", function (ev: any) {
        drop(ev, changeFiles, file_upload)
    }, false);
})

</script>


<template>
    <section
        class="w-screen min-h-screen bg-gray-100 grid grid-cols-[30%_70%] -lg:grid-cols-1 justify-center items-center p-8 gap-4">
        <div class="lg:w-[30%] min-h-screen lg:overflow-y-auto lg:fixed lg:left-0 mx-auto bg-white shadow p-8">
            <form>
                <div class="flex flex-col gap-8">
                    <div>
                        <p class="text-sm mb-2 flex items-center justify-center">
                            <span class="font-bold">
                                Photos <span class="">-></span> {{ total }}/50 -
                            </span>
                            <span>
                                You can add up to 50 photos
                            </span>
                        </p>
                        <FileUpload @file-upload="fileUpload" file_type="image" />
                    </div>
                    <div class="flex flex-col">
                        <label for="listing_title" class="capitalize font-bold text-lg mb-3">listing title</label>
                        <input type="text" name="listing title" id="listing_title" placeholder="Enter listing title">
                    </div>
                    <div class="flex flex-col">
                        <label for="property_status" class="capitalize font-bold text-lg mb-3">property status</label>
                        <select name="property status" id="proptery-status">
                            <option disabled> Choose property status</option>
                            <option value="rent">For Rent</option>
                            <option value="sale">For Sale</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="price_per_month" class="capitalize font-bold text-lg mb-3">price per month</label>
                        <input type="text" name="listing title" id="price_per_month"
                            placeholder="Enter the price per month">
                    </div>

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
    </section>
</template>