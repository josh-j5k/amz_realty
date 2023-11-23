<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
defineProps<{
    class: string
}>()
</script>
<template>
    <Link :href="route('Home')">

    <img src="/images/hsh.png" alt="">
    </Link>
</template>
<style scoped>
    .cls-1 {
        fill: #175fef;
    }

    .cls-2 {
        fill: none;
        stroke: #175fef;
        stroke-miterlimit: 10;
        stroke-width: 37.11px;
    }
</style>