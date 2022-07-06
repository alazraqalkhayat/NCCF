<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'flex items-center justify-center rounded-xl w-44 h-10 items-center bg-indigo-400 text-sm font-medium leading-5 text-gray-50 focus:outline-none focus:bg-indigo-700 transition'
        : 'flex items-center justify-center rounded-xl w-44 h-10 items-center bg-transparent text-sm font-medium leading-5 text-gray-900 hover:text-gray-50 hover:bg-indigo-400 focus:outline-none focus:text-gray-50 transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
