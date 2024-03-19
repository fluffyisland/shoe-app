<script setup>
import { CircleCheck, X } from "lucide-vue-next";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    orders: Object,
    orderStatus: Object,
});
const form = useForm({
    id: "",
    slip_image: "",
    order_status: "",
    status: "",
});
const showSlipModal = ref(false);
const openSlipModal = (id, slip_image, order_status) => {
    form.id = id;
    form.slip_image = slip_image;
    form.order_status = order_status;
    showSlipModal.value = true;
};
const closeSlipModal = () => {
    showSlipModal.value = false;
};
const confirmOrder = () => {
    closeSlipModal();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showDenyButton: true,
        denyButtonText: `Close`,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes, Confirm it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.status = 1;
            form.put(
                route("admin.order.update", {
                    order: form.id,
                })
            );
        } else if (result.isDenied) {
            showSlipModal.value = true;
        }
    });
};
const cancleOrder = () => {
    closeSlipModal();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showDenyButton: true,
        denyButtonText: `Close`,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes, Cancle it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.status = 2;
            form.put(
                route("admin.order.update", {
                    order: form.id,
                })
            );
        } else if (result.isDenied) {
            showSlipModal.value = true;
        }
    });
};
</script>

<template>
    <AdminLayout title="Dashboard">
        <div class="relative overflow-x-auto shadow-md">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Total Price</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Slip</th>
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
                            <td class="px-6 py-4">
                                <button @click="
                        openSlipModal(
                            order.id,
                            order.slip_image,
                            order.status
                        )
                        " type="button" class="font-medium text-blue-600 hover:underline">
                                    Slip
                                </button>
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
    </AdminLayout>

    <DialogModal :show="showSlipModal" @close="closeSlipModal">
        <template #title>
            <div class="flex flex-row justify-between gap-1">
                <span> Slip Order Id {{ form.id }} </span>
                <button class="btn btn-circle" @click="closeSlipModal" type="button">
                    <X class="text-gray-700" size="22" />
                </button>
            </div>
        </template>

        <template #content>
            <div class="flex flex-col gap-3">
                <img class="max-w-[568px] mx-auto" :src="'/storage/' + form.slip_image" alt="slip image" />
                <div class="flex justify-end gap-1">
                    <button :disabled="form.order_status == '2'" @click="cancleOrder"
                        class="btn btn-danger flex flex-row gap-2 items-center" type="button">
                        <X size="20" />
                        <span> Cancle </span>
                    </button>
                    <button @click="confirmOrder" :disabled="form.order_status == '2' || form.order_status == '1'
                        " class="btn btn-success flex flex-row gap-2 items-center" type="button">
                        <CircleCheck size="20" />
                        <span> Confirm </span>
                    </button>
                </div>
            </div>
        </template>
    </DialogModal>
</template>
