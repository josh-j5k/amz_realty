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
        <title>House, properties to rent and for sale</title>
    </Head>
    <AppLayout>
        <section class="relative h-screen w-full isolate flex flex-col items-center justify-center px-2">
            <div
                class="w-full h-screen absolute inset-0 -z-10 before:content-emptystring before:absolute before:inset-0 before:bg-black-opacity-50 before:w-full before:h-full">
                <img src="images/house-with-balcony-sky-background.jpg" alt="background-img"
                    class="w-full h-screen object-cover">
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
        <section class="py-8 w-full lg:min-h-screen grid">
            <div class="grid lg:grid-cols-2 grid-cols w-5/6 gap-4 mx-auto items-center">
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
                <div class="-lg:row-start-1 -lg:row-end-1 -lg:pt-16">
                    <img src="/images/high-view-hands-stationery-items.jpg" alt="house valuation" class="">
                </div>
            </div>
        </section>
        <section class="min-h-32 bg-secondary py-12 mb-8 px-8 grid items-center text-white">
            <div class="flex md:justify-between -md:flex-col -md:gap-6 w-5/6 mx-auto">
                <h2 class="md:text-3xl text-2xl font-bold text-center">
                    Your property search just got easier
                </h2>
                <button type="button" class="border border-white capitalize p-2"> find a house</button>
            </div>
        </section>
        <section class="p-8 pt-12">
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
        <section class="lg:h-[90vh] p-12 mt-16">
            <div class="grid lg:grid-cols-[40%_60%] grid-cols-1 items-center justify-center lg:w-5/6 mx-auto gap-8">
                <div>
                    <h2 class="lg:text-3xl text-2xl font-bold mb-6">
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
                <div class="grid grid-cols-1 lg:grid-cols-3 lg:grid-rows-2 lg:gap-2 gap-6">
                    <div class="w-full relative">
                        <img src="/images/355280246_2871413009661347_7662648592867538430_n.jpg" alt="house interior"
                            class="lg:max-w-[250px] w-full aspect-square object-cover rounded-lg">
                        <span class="bg-secondary text-white py-1 px-2.5 rounded absolute top-12 -left-8">
                            04:70:00
                        </span>
                    </div>
                    <div class=" w-full lg:row-start-1 lg:row-end-3 lg:col-start-2 lg:col-end-3">
                        <div class="grid items-end h-full w-full relative">
                            <img src="/images/385808252_849018929958297_1588544965478260459_n.jpg" alt="house exterior"
                                class="lg:max-w-[250px] w-full aspect-square object-cover rounded-lg">
                            <span
                                class="bg-secondary text-white py-1 px-2.5 rounded absolute lg:bottom-1/3 -lgtop-12 -left-8">
                                15:30:90
                            </span>
                        </div>
                    </div>
                    <div class="w-full relative">
                        <img src="/images/385909430_1003122750912505_3112270827831116516_n.jpg" alt="house interior"
                            class="lg:max-w-[250px] w-full aspect-square object-cover rounded-lg">
                        <span class="bg-secondary text-white py-1 px-2.5 rounded absolute top-12 -left-8">
                            22:10:20
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <section class="lg:min-h-screen p-12 bg-slate-100">
            <div class="md:w-5/6 mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 ">
                <Card class="p-8 w-full bg-white">
                    <h3 class="mb-6 text-2xl font-bold">
                        Help me choose
                    </h3>
                    <p>
                        We can help you find your dream home by guiding you through a few simple steps and matching you with
                        tailor-made property listings.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-blue-900 text-white">
                    <h3 class="mb-6 text-2xl font-bold">
                        Introducing wish list
                    </h3>
                    <p>
                        What are the things you’re really looking for in your next property? Create a Wish List of features,
                        from deal-breakers to nice-to-haves, then we’ll sort your property search results accordingly. It’s
                        that simple.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-secondary text-white">
                    <h3 class="mb-6 text-2xl font-bold">
                        Travel Time Search
                    </h3>
                    <p>
                        Need to find a property near your workplace, children’s school or train station? We’ll help you find
                        your dream property in the right location.
                    </p>
                </Card>
                <Card class="p-8 w-full bg-slate-900 text-white">
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