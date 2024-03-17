<script setup>
import { Link } from "@inertiajs/vue3";
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
defineProps({
    shoes: Object,
});
</script>

<template>
    <CustomerLayout title="Welcome">
        <h1>Welcome</h1>
        <div class="grid lg:grid-cols-4 grid-cols-5 gap-y-10">
            <template v-for="shoe in shoes.data" :key="shoe.id">
                <Link
                    :href="
                        route('customer.welcome.show', {
                            id: shoe.id,
                        })
                    "
                    class="space-y-3"
                >
                    <img
                        class="max-w-[300px] border border-gray-200 hover:scale-[101%]"
                        :src="'/storage/' + shoe.shoe_colors[0].photo_url"
                        :alt="shoe.name"
                    />
                    <h1 class="text-blue-600 text-4xl font-bold">
                        {{ shoe.price }} $
                    </h1>
                    <h2 class="text-2xl font-lg font-semibold">
                        {{ shoe.name }}
                    </h2>
                </Link>
            </template>
        </div>
    </CustomerLayout>
</template>
