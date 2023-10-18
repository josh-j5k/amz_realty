<script setup lang="ts">
const props = defineProps<{
    id?: string
}>()
</script>

<template>
    <button :id="id"
        class="inline-flex items-center px-4 py-2 bg-accent border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-hover focus:bg-accent-hover active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
