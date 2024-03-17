<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { CircleCheck, X } from "lucide-vue-next";
import Swal from "sweetalert2";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    orders: Object,
    orderStatus: Object,
});
</script>

<template>
    <CustomerLayout title="Order">
        <div>
            <div class="relative overflow-x-auto shadow-md">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Order ID</th>
                            <!-- <th scope="col" class="px-6 py-3">Customer Name</th> -->
                            <th scope="col" class="px-6 py-3">Shoe</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Total Price</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <!-- <th scope="col" class="px-6 py-3">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="order in orders.data"
                            :key="order.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ order.id }}
                            </th>
                            <!-- <td class="px-6 py-4">{{ order.user.name }}</td> -->
                            <td class="px-6 py-4">
                                <span>
                                    {{ order.shoe.name }}
                                </span>
                                <span class="text-sm">
                                    ({{ order.shoe_color.color }})
                                </span>
                                <span class="text-sm">
                                    ({{ order.shoe.type }})
                                </span>
                                <span class="text-sm">
                                    ({{ order.shoe_size.size }})
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ order.price }}</td>
                            <td class="px-6 py-4">{{ order.quantity }}</td>
                            <td class="px-6 py-4">
                                {{ order.price * order.quantity }}
                            </td>
                            <td class="px-6 py-4">
                                <span :class="orderStatus[order.status].color">
                                    {{ orderStatus[order.status].label }}
                                </span>
                            </td>

                            <!-- <td class="px-6 py-4">
                                <button
                                    @click="
                                        openSlipModal(
                                            order.id,
                                            order.slip_image,
                                            order.status
                                        )
                                    "
                                    type="button"
                                    class="font-medium text-blue-600 hover:underline"
                                >
                                    Slip
                                </button>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Pagination :links="orders.links" />
    </CustomerLayout>
</template>
