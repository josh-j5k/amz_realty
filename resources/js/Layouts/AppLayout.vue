<script setup lang="ts">
import { ref, } from 'vue';
import { router } from '@inertiajs/vue3';
import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import Preloader from '@/Components/Preloader.vue';
const preload = ref(false)
router.on('start', () => preload.value = true)
router.on('finish', (event) => {
    if (event.detail.visit.completed) {
        preload.value = false
    } else if (event.detail.visit.interrupted) {
        preload.value = false
    } else if (event.detail.visit.cancelled) {
        preload.value = false
    }
})
</script>

<template>
    <Header />
    <main>
        <Preloader v-if="preload" />
        <slot />
    </main>
    <Footer />
</template>