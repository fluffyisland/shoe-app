<script setup>
import AppLayout from "./AppLayout.vue";
defineProps({
    title: String,
});
</script>

<template>
    <AppLayout :title="title">
        <main class="container">
            <slot />
        </main>
    </AppLayout>
</template>
