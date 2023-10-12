<script setup lang="ts">
import { router } from '@inertiajs/vue3';
const props = defineProps<{
    routeName: string,
    position: string
}>()
</script>
<template>
    <button @click="router.get(route(routeName))" type="button" title="close"
        class="absolute w-8 aspect-square text-white bg-slate-700 rounded-full z-20" :class="position">
        <span>
            <i class="fas fa-xmark"></i>
        </span>
    </button>
</template>