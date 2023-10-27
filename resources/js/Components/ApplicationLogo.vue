<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
defineProps<{
    class: string
}>()
</script>
<template>
    <Link :href="route('Home')">
    <svg :class="class" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 645 430.56">
        <g>
            <rect class="cls-1" width="31" height="331" />
            <rect class="cls-1" x="175" width="31" height="331" />
            <rect class="cls-1" x="31" y="152" width="144" height="27" />
        </g>
        <g>
            <rect class="cls-1" x="439" width="31" height="331" />
            <rect class="cls-1" x="614" width="31" height="331" />
            <rect class="cls-1" x="470" y="152" width="144" height="27" />
        </g>
        <path class="cls-2"
            d="m414.54,179.12s-.51-54.82-59.63-68.62h-61.84s-53.01,5.21-60.62,68.62c0,0,.28,53.56,59.39,67.35,10.55,1.68,21.1,3.35,31.64,5.03,7.12,1.14,18.27,2.9,32,5,26.5,4.06,29.73,4.34,33.88,6.36,7.25,3.53,22.11,14.73,25.16,58.93,0,0,11.31,76.42-55.69,90.21h-68.62s-25.5-3.69-42.67-25.69c-19.07-24.42-15.79-51.93-15.1-56.64" />
    </svg>
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