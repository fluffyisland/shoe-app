<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    links: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="p-6">
        <template v-for="link in links" :key="link.label">
            <Link v-if="link.url" class="btn btn-light" :href="link.url">
                <span
                    :class="{ 'font-semibold text-blue-600': link.active }"
                    v-html="link.label"
                >
                </span>
            </Link>
        </template>
    </div>
</template>
