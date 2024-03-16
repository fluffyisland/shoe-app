<script setup>
import Swal from "sweetalert2";
import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const style = ref("");
const message = ref("");
const title = ref("");

watchEffect(async () => {
    title.value = page.props.jetstream.flash?.sweetTitle;
    message.value = page.props.jetstream.flash?.sweetMessage;
    style.value = page.props.jetstream.flash?.sweetStyle;

    if (style.value && message.value && title.value) {
        Swal.fire({
            icon: style.value,
            title: title.value,
            text: message.value,
            confirmButtonText : "ปิด X"
        });
    }
});
</script>

<template></template>
