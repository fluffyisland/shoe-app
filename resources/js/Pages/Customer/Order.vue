<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    orders: Object,
    orderStatus: Object,
});
</script>

<template>
    <CustomerLayout title="Order">
        <div class="relative overflow-x-auto shadow-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Total Price</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="order in orders.data" :key="order.id">
                        <tr class="odd:bg-white  even:bg-gray-50 ">
                            <th scope="row" class="px-6 py-4">
                                {{ order.id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ order.total_amount }}
                            </td>
                            <td :class="orderStatus[order.status].color" class="px-6 py-4">
                                {{ orderStatus[order.status].label }}
                            </td>
                        </tr>
                        <tr span="3">
                            <div class="relative">
                                <table class="text-sm text-left rtl:text-right text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">#</th>
                                            <th scope="col" class="px-6 py-3">Name</th>
                                            <th scope="col" class="px-6 py-3">Type</th>
                                            <th scope="col" class="px-6 py-3">Color</th>
                                            <th scope="col" class="px-6 py-3">Size</th>
                                            <th scope="col" class="px-6 py-3">Price</th>
                                            <th scope="col" class="px-6 py-3">Quantity</th>
                                            <th scope="col" class="px-6 py-3">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(order_shoe, index) in order.order_shoes" :key="order.id">
                                            <tr class="odd:bg-white">
                                                <th scope="row" class="px-6 py-4">
                                                    {{ index + 1 }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe.type }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe_color.color }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe_size.size }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe.price }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.quantity }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ order_shoe.shoe.price * order_shoe.quantity }}
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <Pagination :links="orders.links" />
    </CustomerLayout>
</template>
