<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'text-accent font-bold lg:border-b-2 lg:pb-[1px] lg:border-accent' : ''
);
</script>

<template>
    <Link :href="href" :class="classes" class="hover:border-b-2 border-accent">
    <slot />
    </Link>
</template>
