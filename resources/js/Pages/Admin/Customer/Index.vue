<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import Swal from "sweetalert2";
import { useForm } from "@inertiajs/vue3";
defineProps({
    users: Object,
});
const form = useForm({});
const deleteUser = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(
                route("admin.customer.destroy", {
                    customer: id,
                })
            );
        }
    });
};
</script>

<template>
    <AdminLayout title="Dashboard">
        <div>
            <div class="relative overflow-x-auto shadow-md">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in users.data"
                            :key="user.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                <div class="flex items-center gap-3">
                                    <img
                                        class="h-8 w-8 rounded-full object-cover"
                                        :src="user.profile_photo_url"
                                        :alt="user.name"
                                    />
                                    <span>
                                        {{ user.name }}
                                    </span>
                                </div>
                            </th>
                            <td class="px-6 py-4">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <button
                                    @click="deleteUser(user.id)"
                                    type="button"
                                    class="font-medium text-red-600 hover:underline"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Pagination :links="users.links" />
    </AdminLayout>
</template>
