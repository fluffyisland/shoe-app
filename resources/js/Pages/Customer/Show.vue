<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { CircleCheck, X } from "lucide-vue-next";
import Swal from "sweetalert2";

const props = defineProps({
    shoe: Object,
});
const show = ref(false);
const formData = ref(new FormData());
const loading = ref(false);
const form = useForm({
    shoe_id: props.shoe.id,
    sizes: props.shoe.shoe_colors[0].shoe_sizes,
    photo_url: props.shoe.shoe_colors[0].photo_url,
    color: props.shoe.shoe_colors[0],
    shoe_color_id: props.shoe.shoe_colors[0].id,
    colorIndex: 0,
    sizeIndex: 0,
    size: "",
    shoe_size_id: "",
    quantity: 0,
    slip_image: "",
    price: props.shoe.price,
});
const setColor = (color, index, sizes) => {
    form.photo_url = color.photo_url;
    form.colorIndex = index;
    form.sizes = sizes;
    form.quantity = 0;
    form.color = color;
    form.shoe_color_id = color.id;
};
const setSize = (size, index) => {
    form.sizeIndex = index;
    form.shoe_size_id = size.id;
    form.size = size;
    form.quantity = 0;
};
const increaseQuantity = () => {
    if (form.quantity < form.size.stock) {
        form.quantity++;
    }
};
const decreaseQuantity = () => {
    if (form.quantity >= 0) {
        form.quantity--;
    }
};
const openModal = () => {
    show.value = true;
};
const closeModal = () => {
    show.value = false;
};
const handlePhoto = (event, variantIndex) => {
    const file = event.target.files[0];
    formData.value.append("photo_url", file);
    uploadPhoto(formData.value);
};
const uploadPhoto = (formData) => {
    loading.value = true;
    axios
        .post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            form.slip_image = response.data.path;
        })
        .catch((error) => {
            Swal.fire("Error!", "Error uploading file:" + error, "error");
            console.error("Error uploading file:", error);
        })
        .finally(() => {
            FormData.value = null;
            loading.value = false;
        });
};
const submit = () => {
    form.post(route("customer.order.store"), {
        onSuccess: () => {
            closeModal();
        },
    });
};
onMounted(() => {
    show.value = false;
});
</script>

<template>
    <CustomerLayout title="Show">
        <div class="flex">
            <img
                class="w-[450px] h-[600px]"
                :src="'/storage/' + form.photo_url"
                :alt="shoe.name"
            />
            <div>
                <div class="prose mb-3">
                    <h3>
                        {{ shoe.name }}
                    </h3>
                    <p>
                        {{ shoe.description }}
                    </p>
                </div>
                <span class="text-3xl font-bold"> {{ shoe.price }} $ </span>

                <div class="mt-4">
                    <template
                        v-for="(color, index) in shoe.shoe_colors"
                        :key="color.id"
                    >
                        <button
                            :class="
                                form.colorIndex == index
                                    ? 'bg-gray-800 text-white'
                                    : ' bg-white enabled:hover:bg-gray-200 enabled:focus:ring-gray-100 border text-gray-900 border-gray-200'
                            "
                            @click="setColor(color, index, color.shoe_sizes)"
                            class="w-fit px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            {{ color.color }}
                        </button>
                    </template>
                </div>
                <div class="mt-4">
                    <template
                        v-for="(size, index) in form.sizes"
                        :key="size.id"
                    >
                        <button
                            :class="
                                form.sizeIndex == index &&
                                form.size.id == size.id
                                    ? 'bg-gray-800 text-white'
                                    : ' bg-white enabled:hover:bg-gray-200 enabled:focus:ring-gray-100 border text-gray-900 border-gray-200'
                            "
                            @click="setSize(size, index)"
                            class="w-fit px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            {{ size.size }}
                        </button>
                    </template>
                </div>
                <div class="mt-4">
                    <div class="flex">
                        <button
                            :disabled="!form.size"
                            @click="decreaseQuantity"
                            type="button"
                            class="btn btn-light"
                        >
                            <span class="text-2xl"> - </span>
                        </button>
                        <p
                            class="min-w-[200px] text-black text-center text-2xl py-2"
                        >
                            {{ form.quantity }}
                        </p>
                        <button
                            :disabled="!form.size"
                            @click="increaseQuantity"
                            type="button"
                            class="btn btn-light"
                        >
                            <span class="text-2xl"> + </span>
                        </button>
                    </div>
                </div>
                <div>
                    <button
                        @click="openModal"
                        :disabled="!form.size || form.quantity == 0"
                        type="button"
                        class="w-full px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 text-white font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70 bg-blue-700 enabled:hover:bg-blue-800 enabled:focus:ring-blue-300"
                    >
                        Buy
                    </button>
                </div>
            </div>
        </div>
    </CustomerLayout>
    <DialogModal :show="show" @close="closeModal">
        <template #title>
            <div class="flex flex-row justify-between gap-1 w-full">
                <span> Buying {{ shoe.name }} {{ form.color.color }} </span>
                <button
                    class="btn btn-circle"
                    @click="closeModal"
                    type="button"
                >
                    <X class="text-gray-700" size="22" />
                </button>
            </div>
        </template>
        <template #content>
            <form @submit.prevent="submit" class="prose">
                <div>
                    <img
                        class="max-h-[250px] mx-auto rounded-md"
                        src="/storage/uploads/GSB.png"
                        alt="GSB"
                    />
                    <h3 class="text-center">Bank GSB</h3>
                    <h3 class="text-center">Bank Number 020166916765</h3>
                    <h3 class="text-center">Name Chacrit Poonpipit</h3>
                    <h3 class="text-center">
                        Total Price
                        {{ parseInt(shoe.price) * parseInt(form.quantity) }} $
                    </h3>
                </div>

                <div class="mb-3">
                    <label class="label" for="slip_image">Slip</label>
                    <input
                        id="slip_image"
                        @change="handlePhoto"
                        class="input"
                        type="file"
                        accept="image/*"
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.slip_image"
                    />
                </div>

                <div v-if="form.slip_image" class="mb-3">
                    <img
                        class="max-h-[180px] rounded-lg border border-gray-300"
                        :src="'/storage/' + form.slip_image"
                        alt="image preview"
                    />
                </div>

                <div class="flex justify-end mt-2">
                    <button
                        :disabled="loading || form.processing"
                        class="btn btn-primary"
                        type="submit"
                    >
                        Confirm
                    </button>
                </div>
            </form>
        </template>
    </DialogModal>
</template>
