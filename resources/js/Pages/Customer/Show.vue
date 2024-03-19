<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { CircleCheck, X, ShoppingCart } from "lucide-vue-next";
import Swal from "sweetalert2";
const props = defineProps({
    shoe: Object,
});
const form = useForm({
    shoe_id: props.shoe.id,
    sizes: props.shoe.shoe_colors[0].shoe_sizes,
    photo_url: props.shoe.shoe_colors[0].photo_url,
    color: props.shoe.shoe_colors[0],
    shoe_color_id: props.shoe.shoe_colors[0].id,
    shoe_size_id: "",
    colorIndex: 0,
    sizeIndex: 0,
    size: "",
    quantity: 0,
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
    if (form.quantity >= 1) {
        form.quantity--;
    }
};
const addToCart = () => {
    const cartData = {
        shoe: props.shoe,
        color: form.color,
        size: form.size,
        quantity: form.quantity,
        price: form.price,
    };

    let existingCart = JSON.parse(localStorage.getItem('carts')) || [];
    existingCart.push(cartData);
    localStorage.setItem('carts', JSON.stringify(existingCart));

    Swal.fire({
        title: 'Success',
        text: 'Item added to cart!',
        icon: 'success',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });
}

</script>

<template>
    <CustomerLayout title="Show">
        <div class="flex flex-col w-fit">
            <img class="w-[300px] h-[300px]" :src="'/storage/' + form.photo_url" :alt="shoe.name" />
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
                    <template v-for="(color, index) in shoe.shoe_colors" :key="color.id">
                        <button :class="form.colorIndex == index
                ? 'bg-gray-800 text-white'
                : ' bg-white enabled:hover:bg-gray-200 enabled:focus:ring-gray-100 border text-gray-900 border-gray-200'
                " @click="setColor(color, index, color.shoe_sizes)"
                            class="w-fit px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70">
                            {{ color.color }}
                        </button>
                    </template>
                </div>
                <div class="mt-4">
                    <template v-for="(size, index) in form.sizes" :key="size.id">
                        <button :class="form.sizeIndex == index &&
                form.size.id == size.id
                ? 'bg-gray-800 text-white'
                : ' bg-white enabled:hover:bg-gray-200 enabled:focus:ring-gray-100 border text-gray-900 border-gray-200'
                " @click="setSize(size, index)"
                            class="w-fit px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70">
                            {{ size.size }}
                        </button>
                    </template>
                </div>
                <div class="mt-4">
                    <div class="flex">
                        <button :disabled="!form.size" @click="decreaseQuantity" type="button" class="btn btn-light">
                            <span class="text-2xl"> - </span>
                        </button>
                        <p class="min-w-[200px] text-black text-center text-2xl py-2">
                            {{ form.quantity }}
                        </p>
                        <button :disabled="!form.size" @click="increaseQuantity" type="button" class="btn btn-light">
                            <span class="text-2xl"> + </span>
                        </button>
                    </div>
                </div>
                <div>
                    <button @click="addToCart" :disabled="!form.size || form.quantity == 0" type="button"
                        class="w-full px-5 py-2.5 me-2 mb-2 rounded-lg transition-colors duration-200 text-white font-medium text-sm focus:outline-none focus:ring-4 disabled:cursor-not-allowed disabled:opacity-70 bg-blue-700 enabled:hover:bg-blue-800 enabled:focus:ring-blue-300 flex gap-2 justify-center items-center">
                        <ShoppingCart />
                        <span>
                            Add To Cart
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>
