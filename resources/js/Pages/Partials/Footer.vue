<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <footer class="p-12 bg-black text-white">
        <div class="w-5/6 mx-auto grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <ApplicationLogo width="50" />
                <h3 class="mt-4 font-bold">Socials</h3>
                <div class="flex gap-4">
                    <span><i class="fa-brands fa-instagram"></i></span>
                    <span><i class="fa-brands fa-facebook"></i></span>
                    <span><i class="fa-brands fa-twitter"></i></span>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold mb-6">
                    Top Pages
                </h2>
                <a>
                    Home
                </a>
                <a>
                    Home
                </a>
                <a>
                    Home
                </a>
                <a>
                    Home
                </a>
            </div>
            <div class="flex flex-col">
                <h2 class="text-2xl font-bold mb-6">
                    About Us
                </h2>
                <a>
                    Home
                </a>
                <a>
                    Home
                </a>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-6">
                    Newsletter
                </h2>
                <p class="mb-3">
                    Signup to our newsletter
                </p>
                <form action="">
                    <input type="text" name="" id="" class="w-full mb-4">
                    <button type="submit" title="submit" class="py-2 px-6 bg-accent text-white">
                        Signup
                    </button>
                </form>

            </div>
        </div>
    </footer>
</template>