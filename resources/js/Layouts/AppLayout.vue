<script setup>
import { Head, router } from "@inertiajs/vue3";
import Sweet from "@/Components/Sweet.vue";
defineProps({
    title: String,
});
const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <Head :title="title" />
    <Sweet />
    <slot />
    <button v-if="$page.props.auth.user" @click="logout" type="button">logout</button>
</template>
