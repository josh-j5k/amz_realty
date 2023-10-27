<script setup lang="ts">

import Header from '@/Pages/Partials/Header.vue';
import Footer from '@/Pages/Partials/Footer.vue';
import Preloader from '@/Components/Preloader.vue';
import { usePreloader } from '@/Composables/UsePreloader';
const { preload, showClosePreloader } = usePreloader()
showClosePreloader()
</script>

<template>
    <Preloader v-if="preload" />
    <Header />
    <main>
        <slot />
    </main>
    <Footer />
</template>