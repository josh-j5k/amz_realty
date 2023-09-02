<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    Status: 'any',
    location: '',
    property_type: ''
})

</script>
form
<template>
    <AppLayout>
        <section class="relative h-screen w-screen isolate flex flex-col items-center justify-center px-2">
            <div
                class="w-screen h-screen absolute inset-0 -z-10 before:content-[''] before:absolute before:inset-0 before:bg-bg-black-opacity-50 before:w-full before:h-full">
                <img src="Images/house-with-balcony-sky-background.jpg" alt="background-img"
                    class="w-screen h-screen object-cover">
            </div>
            <h2 class="md:text-5xl text-4xl text-white font-bold max-w-2xl text-center mb-12">Lets find a home that is
                perfect for you
            </h2>

            <form action="">

                <div class="text-white flex justify-center gap-4">
                    <label for="any-status" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md "
                        :class="form.Status === 'any' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Any Status
                    </label>
                    <input class="hidden" type="radio" value="any" v-model="form.Status" name="any-status" id="any-status">
                    <label for="rent" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md"
                        :class="form.Status === 'rent' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Rent
                    </label>
                    <input class="hidden" type="radio" value="rent" v-model="form.Status" name="rent" id="rent">
                    <label for="sale" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md "
                        :class="form.Status === 'sale' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Sale
                    </label>
                    <input class="hidden" type="radio" value="sale" v-model="form.Status" name="sale" id="sale">
                </div>
                <!-- Form Inputs -->
                <div
                    class="md:w-[672px] w-[90vw] md:h-20 bg-white rounded-lg flex flex-col md:flex-row md:gap-4 items-center md:pl-8 overflow-hidden ">
                    <div class="flex flex-col md:min-w-[240px] w-full py-4 -md:px-8">
                        <label for="location" class="font-bold">
                            Location
                        </label>
                        <div class="flex items-center gap-4 w-full relative">
                            <input required v-model="form.location" type="text" placeholder="Type your town, region"
                                id="location" class="border-none bg-gray-100 focus:outline-none focus:ring-0 w-full">
                            <span class="absolute right-2"><i class="fas fa-map"></i></span>
                        </div>
                    </div>
                    <div class="md:w-[1px] w-full md:h-14 h-[1px] bg-slate-300">&nbsp;</div>
                    <div class="flex flex-col md:min-w-[240px] w-full py-4 -md:px-8">
                        <label for="property-type" class="font-bold ">
                            Property Type
                        </label>
                        <div class="flex items-center gap-4 w-full relative">
                            <select required v-model="form.property_type" id="property-type"
                                class="border-none outline-none appearance-none focus:ring-0 bg-gray-100 w-full">
                                <option value="" disabled>Please select an option</option>
                                <option value="room">
                                    Room
                                </option>
                                <option value="studio">
                                    Studio
                                </option>
                                <option value="appartment">
                                    Appartment
                                </option>
                                <option value="duplex">
                                    Duplex
                                </option>
                            </select>
                            <span class="absolute right-2"><i class="fas fa-caret-down"></i></span>
                        </div>
                    </div>
                    <button title="search" type="submit"
                        class="bg-accent hover:bg-accent-hover md:h-full h-16 w-full  text-white">
                        <span><i class="fas fa-search fa-xl"></i></span>
                    </button>
                </div>
            </form>
        </section>
        <section class="py-8 w-screen min-h-screen grid">
            <div class="grid md:grid-cols-2 grid-cols w-5/6 gap-4 mx-auto items-center">
                <div>
                    <h2 class="font-bold text-3xl mb-6">When are you looking to market your property?</h2>
                    <p>
                        The simple, free, no-obligation way to request an accurate
                        valuation of your home from estate and letting agents who are
                        experts in your local area. Watch our TV advert now.
                    </p>
                    <button title="start valuation" type="button"
                        class="capitalize px-4 py-3  bg-accent hover:bg-accent-hover text-white mt-6">
                        start
                        instant
                        valuation</button>
                </div>
                <div class="-md:row-start-1 -md:row-end-1 -md:pt-16">
                    <img src="/Images/high-view-hands-stationery-items.jpg" alt="house valuation" class="">
                </div>
            </div>
        </section>
        <section class="min-h-32 bg-secondary py-12 px-8 grid items-center text-white">
            <div class="flex md:justify-between -md:flex-col -md:gap-6 w-5/6 mx-auto">
                <h2 class="md:text-3xl text-2xl font-bold text-center">
                    Your property search just got easier
                </h2>
                <button type="button" class="border border-white capitalize p-2"> find a house</button>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
    select::-ms-expand {
        display: none;
    }

    #property-type {
        background-image: none;
    }
</style>