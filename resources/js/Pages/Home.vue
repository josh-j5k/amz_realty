<script setup lang="ts">
import SkeletonLoader from '@/Components/SkeletonLoader.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Card.vue';
import { Link, useForm, Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useGoogleMaps } from '@/Composables/UseGoogleMaps'
import { Loader } from "@googlemaps/js-api-loader"
const options = {
    componentRestrictions: { country: "cm" },
    strictBounds: false,
};
const loader = new Loader({
    apiKey: "AIzaSyAj3t8m1tT8R9LuME3pcNedY9IK6aUjsu4",
    version: "weekly",
    libraries: ['places'],
});

const { usePlaces } = useGoogleMaps()
const input = ref('input')
const form = useForm({
    status: 'any',
    location: '',
    property_type: ''
})
const formError = ref(false)
function validate(): boolean {
    if (form.location.length === 0 || form.property_type.length === 0) {
        formError.value = true
        return false
    } else {
        return true
    }
}
function submit() {
    if (validate()) {
        form.get('/listings')
    }
}
onMounted(() => {
    const locationInput = <HTMLInputElement>document.getElementById('location')
    // usePlaces(locationInput, form.location)
    loader.importLibrary('places').then(res => {

        const autocomplete = new res.Autocomplete(locationInput, options)

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace()
            form.location = place.formatted_address

        })

    })
})

</script>

<template>
    <Head>
    </Head>
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

            <form @submit.prevent="submit">

                <div class="text-white flex justify-center gap-4">
                    <label for="any-status" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md "
                        :class="form.status === 'any' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Any Status
                    </label>
                    <input class="hidden" type="radio" value="any" v-model="form.status" name="any-status" id="any-status">
                    <label for="rent" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md"
                        :class="form.status === 'rent' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Rent
                    </label>
                    <input class="hidden" type="radio" value="rent" v-model="form.status" name="rent" id="rent">
                    <label for="sale" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md "
                        :class="form.status === 'sale' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Sale
                    </label>
                    <input class="hidden" type="radio" value="sale" v-model="form.status" name="sale" id="sale">
                </div>
                <!-- Form Inputs -->
                <div
                    class="md:w-[672px] w-[90vw] md:h-20 bg-white rounded-lg flex flex-col md:flex-row md:gap-4 items-center md:pl-8 overflow-hidden ">
                    <div class="flex flex-col md:min-w-[240px] w-full py-4 -md:px-8">
                        <label for="location" class="font-bold">
                            Location
                        </label>
                        <div class="flex items-center gap-4 w-full relative">
                            <input ref="input" required v-model="form.location" type="text"
                                placeholder="Type your town, region" id="location"
                                class="border-none bg-gray-100 focus:outline-none focus:ring-0 w-full">
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
                <p v-if="formError" class="text-red-500 capitalize text-center font-bold">please fill all fields</p>
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
        <section class="p-8">
            <div class="md:w-5/6 w-full mx-auto md:bg-blue-100 rounded-lg">
                <div class="flex md:justify-between -md:flex-col  md:px-16 py-8">
                    <h3 class="md:text-2xl text-xl font-bold text-center">
                        Houses near you
                    </h3>
                    <Link href="" class="text-accent flex justify-center mt-3">
                    <span class="capitalize mr-2">
                        show more houses
                    </span>
                    <span>
                        <i class="fa-regular fa-circle-right"></i>
                    </span>
                    </Link>
                </div>
                <div class="px-8 grid md:grid-cols-4 grid-cols-1 gap-3 md:translate-y-1/4">
                    <template v-for="cards in 4">
                        <div class="w-full h-80 bg-slate-300 shadow">
                            <SkeletonLoader class="w-full h-5/6 bg-slate-300" />
                            <SkeletonLoader class="w-5/6 h-8 mx-auto bg-slate-400" />
                        </div>
                    </template>
                </div>
            </div>
        </section>
        <section class="min-h-screen p-12 mt-16">
            <div class="grid md:grid-cols-2 grid-cols-1 items-center justify-center md:w-5/6 mx-auto gap-12">
                <div>
                    <h2 class="md:text-3xl text-2xl font-bold mb-6">
                        Your property search just got easier
                    </h2>
                    <p class="mb-4">
                        We feature thousands of new properties every month, 24 hours or more before they’re advertised on
                        Rightmove or Zoopla. Find out more about Only With Us properties here.
                    </p>
                    <Link href="" class="text-accent ">
                    <span class="capitalize">
                        start your search
                    </span>
                    <span>
                        <i class="fa-regular fa-circle-right"></i>
                    </span>
                    </Link>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 md:grid-rows-2 gap-2">
                    <div class="w-full h-72 shadow">
                        <SkeletonLoader class="w-full h-full mx-auto bg-slate-300" />
                    </div>
                    <div class=" w-full -md:h-72 md:row-start-1 md:row-end-3 md:col-start-2 md:col-end-3">
                        <div class="grid items-end h-full w-full">
                            <SkeletonLoader class="w-full md:h-1/2 h-full mx-auto bg-slate-300" />
                        </div>
                    </div>
                    <div class="w-full h-72 bg-slate-300 shadow">
                        <SkeletonLoader class="w-full h-8 mx-auto bg-slate-300" />
                    </div>
                </div>
            </div>
        </section>
        <section class="min-h-screen p-12">
            <div class="md:w-5/6 mx-auto grid grid-cols-1 md:grid-cols-4 gap-3 ">
                <Card class="p-8 w-full bg-slate-100">
                    <h3 class="mb-6 text-2xl font-bold">
                        Help me choose
                    </h3>
                    <p>
                        We can help you find your dream home by guiding you through a few simple steps and matching you with
                        tailor-made property listings.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-slate-100">
                    <h3 class="mb-6 text-2xl font-bold">
                        Introducing wish list
                    </h3>
                    <p>
                        What are the things you’re really looking for in your next property? Create a Wish List of features,
                        from deal-breakers to nice-to-haves, then we’ll sort your property search results accordingly. It’s
                        that simple.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-slate-100">
                    <h3 class="mb-6 text-2xl font-bold">
                        Travel Time Search
                    </h3>
                    <p>
                        Need to find a property near your workplace, children’s school or train station? We’ll help you find
                        your dream property in the right location.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-slate-100">
                    <h3 class="mb-6 text-2xl font-bold">
                        Instant Valuation
                    </h3>
                    <p>
                        Our online valuation service gives you a free and instant estimate of your home’s current value in
                        minutes.
                    </p>
                </Card>

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