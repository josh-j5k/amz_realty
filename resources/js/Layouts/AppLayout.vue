<script setup lang="ts">

import Header from '@/Pages/Partials/Header.vue';
// import Footer from '@/Pages/Partials/Footer.vue';

</script>

<template>
    <Header :class="route().current('Home') ? 'absolute inset-0' : ''" />
    <main>
        <slot />
    </main>
    <!-- <Footer /> -->
</template>