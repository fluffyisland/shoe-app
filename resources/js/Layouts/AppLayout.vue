<script setup>
import { Head } from "@inertiajs/vue3";
import Sweet from "@/Components/Sweet.vue";
defineProps({
    title: String,
});
</script>

<template>
    <Head :title="title" />
    <Sweet />
    <slot />
</template>
