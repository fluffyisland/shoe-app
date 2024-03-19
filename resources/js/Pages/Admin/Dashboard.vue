<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
defineProps({
    users: Object,
    orders: Object,
    shoes: Object,
})
</script>

<template>
    <AdminLayout title="Dashboard">
        <div class="flex justify-between gap-6 p-6">
            <!-- Users -->
            <div class="w-1/3 px-3 py-5 shadow-md border rounded-md bg-white">
                <h1 class="text-center text-xl font-bold text-gray-800">
                    Users
                </h1>
                <div class="text-center text-3xl font-bold text-blue-500 mt-2">
                    {{ users.length }}
                </div>
            </div>

            <!-- Shoes -->
            <div class="w-1/3 px-3 py-5 shadow-md border rounded-md bg-white">
                <h1 class="text-center text-xl font-bold text-gray-800">
                    Shoes
                </h1>
                <div class="text-center text-3xl font-bold text-blue-500 mt-2">
                    {{ shoes.length }}
                </div>
            </div>

            <!-- Orders -->
            <div class="w-1/3 px-3 py-5 shadow-md border rounded-md bg-white">
                <h1 class="text-center text-xl font-bold text-gray-800">
                    Orders
                </h1>
                <div class="text-center text-3xl font-bold text-blue-500 mt-2">
                    {{ orders.length }}
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
