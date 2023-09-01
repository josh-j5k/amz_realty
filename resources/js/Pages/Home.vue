<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    Status: 'any',

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
            <h2 class="text-5xl text-white font-bold max-w-2xl text-center mb-12">Lets find a home that is perfect for you
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
                    <label for="sale" class="w-24 h-10 flex items-center justify-center rounded-tl-md rounded-tr-md"
                        :class="form.Status === 'sale' ? 'bg-white text-black border-t-2 border-accent' : 'bg-secondary text-white'">
                        Sale
                    </label>
                    <input class="hidden" type="radio" value="sale" v-model="form.Status" name="sale" id="sale">
                </div>
                <div class="md:w-[672px] max-w-2xl h-16 bg-white rounded-lg flex items-center px-8 py-2">
                    <div class="flex flex-col gap-2">
                        <label for="location">
                            Location
                        </label>
                        <select name="Location" id="location" class="hidden"></select>
                    </div>
                </div>
            </form>
        </section>

    </AppLayout>
</template>

<style scoped></style>