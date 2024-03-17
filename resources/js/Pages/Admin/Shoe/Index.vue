<script setup>
import { X, CirclePlus, CircleMinus, Settings } from "lucide-vue-next";
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";
defineProps({
    shoes: Object,
});
const form = useForm({});

const deleteShoe = (id) => {
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
                route("admin.shoe.destroy", {
                    shoe: id,
                })
            );
        }
    });
};
</script>

<template>
    <AdminLayout title="Dashboard">
        <div class="p-6 space-y-2">
            <div class="flex justify-end">
                <Link
                    :href="route('admin.shoe.create')"
                    class="btn btn-primary flex flex-row gap-2 items-center"
                >
                    <CirclePlus size="20" />
                    <span> Add Shoe </span>
                </Link>
            </div>
            <div class="grid lg:grid-cols-4 gap-4">
                <template v-for="shoe in shoes.data" :key="shoe.id">
                    <template
                        v-for="shoeColor in shoe.shoe_colors"
                        :key="shoeColor.id"
                    >
                        <div
                            class="flex flex-col shadow-md border border-gray-300 rounded-lg overflow-hidden bg-white"
                        >
                            <img
                                class="h-[400px] w-full object-cover border-b"
                                :src="'/storage/' + shoeColor.photo_url"
                                :alt="shoe.name"
                            />
                            <div class="flex flex-col justify-between">
                                <div class="flex flex-col prose px-5 py-3">
                                    <h4>
                                        {{ shoe.name }}
                                        <span class="text-sm mr-1"
                                            >({{ shoeColor.color }})</span
                                        >
                                        <span class="text-sm"
                                            >({{ shoe.type }})</span
                                        >
                                    </h4>
                                    <p>
                                        {{ shoe.description }}
                                    </p>
                                    <h5>Sizes</h5>
                                    <div
                                        class="grid grid-rows-3 grid-cols-3 gap-x-3"
                                    >
                                        <template
                                            v-for="shoeSize in shoeColor.shoe_sizes"
                                        >
                                            <span>
                                                {{ shoeSize.size }}
                                                <span class="text-sm">
                                                    (<span
                                                        >left
                                                        {{
                                                            shoeSize.stock
                                                        }} </span
                                                    >)
                                                </span>
                                            </span>
                                        </template>
                                    </div>
                                    <h6
                                        class="text-blue-600 text-2xl font-semibold"
                                    >
                                        {{ shoe.price }} $
                                    </h6>
                                </div>
                                <div class="flex justify-start p-2">
                                    <Link
                                        :href="
                                            route('admin.shoe.edit', {
                                                shoe: shoe.id,
                                            })
                                        "
                                        class="btn btn-warning flex flex-row gap-2 items-center"
                                    >
                                        <Settings size="20" />
                                        <span> Edit </span>
                                    </Link>
                                    <button
                                        @click="deleteShoe(shoeColor.id)"
                                        class="btn btn-danger flex flex-row gap-2 items-center"
                                        type="button"
                                    >
                                        <CircleMinus size="20" />
                                        <span> Delete </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </div>
        <Pagination :links="shoes.links" />
    </AdminLayout>
</template>
