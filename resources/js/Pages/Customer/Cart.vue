<script setup>
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { X } from "lucide-vue-next";
import Swal from "sweetalert2";
const show = ref(false);
const formData = ref(new FormData());
const loading = ref(false);
const totalPrice = ref(0);
const form = useForm({
    slip_image: "test.jpg",
    total_price: 0,
    carts: [],
});
const carts = ref([]);
const openModal = () => {
    show.value = true;
};
const closeModal = () => {
    show.value = false;
};
const handlePhoto = (event) => {
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
const claerCart = () => {
    localStorage.removeItem('carts');
    window.location.reload();
}
const submit = () => {
    form.total_price = totalPrice;
    form.carts = carts;
    form.post(route("customer.order.store"), {
        onSuccess: () => {
            Swal.fire({
                title: 'Success',
                text: 'Your order has been stored',
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    claerCart();
                }
            });
        },
        onFinish: () => {
            closeModal();
        },
    });
};
const getCart = () => {
    const existingCart = JSON.parse(localStorage.getItem('carts')) || [];
    carts.value = existingCart;
}
const deleteFromCart = (index) => {
    carts.value.splice(index, 1);
    localStorage.setItem('carts', JSON.stringify(carts.value));
    window.location.reload();
}
const countPrice = () => {
    carts.value.forEach(cart => {
        totalPrice.value += cart.price * cart.quantity;
    })
}

onMounted(() => {
    show.value = false;
    getCart()
    countPrice()
});
</script>

<template>
    <CustomerLayout title="Cart">
        <div v-if="carts.length > 0" class="grid grid-cols-12 gap-6">
            <div class="flex flex-col gap-6 col-span-8">
                <template v-for="(cart, index) in carts" :key="cart.shoe.id">
                    <div class="flex flex-row bg-white border rounded-lg">
                        <img class="w-[160px] h-[120px]" :src="'/storage/' + cart.color.photo_url"
                            :alt="cart.shoe.name" />
                        <div class="flex py-2 px-5 gap-6">
                            <div>
                                <h4 class="text-lg font-semibold mb-1">
                                    {{ cart.shoe.name }}
                                </h4>
                                <p class="text-lg mb-1">
                                    Type : {{ cart.shoe.type }}
                                </p>
                                <p class="text-lg mb-1">
                                    Color : {{ cart.color.color }}
                                </p>
                            </div>
                            <div class="min-w-[130px]">
                                <h4 class="text-lg font-semibold mb-1">
                                    Price : {{ cart.shoe.price }}
                                </h4>
                                <h4 class="text-lg font-semibold mb-1">
                                    Quantity : {{ cart.quantity }}
                                </h4>
                                <h4 class="text-lg font-semibold mb-1">
                                    Total Price : {{ cart.shoe.price * cart.quantity }}
                                </h4>
                            </div>
                            <div>
                                <button class="btn btn-danger" @click="deleteFromCart(index)" type="button">
                                    Remove Form Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="col-span-4 bg-white rounded-lg border p-4">
                <div>
                    <div class="flex flex-col gap-2">
                        <template v-for="(cart, index ) in carts" :key="cart.shoe.id">
                            <div>
                                <h5 class="text-lg font-semibold">
                                    {{ index + 1 }} . {{ cart.shoe.name }} <span class="text-sm">({{ cart.color.color
                                        }})</span>
                                </h5>
                                <div class="flex flex-row gap-4">
                                    <p>
                                        $ : {{ cart.shoe.price }}
                                    </p>
                                    <p>
                                        Quantity : {{ cart.quantity }}
                                    </p>
                                    <p>
                                        = {{ cart.shoe.price * cart.quantity }}
                                    </p>
                                </div>
                            </div>
                        </template>
                        <h1 class="text-2xl font-semibold mt-6">
                            Total Price : {{ totalPrice }}
                        </h1>
                        <button @click="openModal" class="btn btn-primary mt-1">
                            Checkbill
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="text-gray-700 text-lg text-center">
                no cart now.
            </p>
        </div>
    </CustomerLayout>
    <DialogModal :show="show" @close="closeModal">
        <template #title>
            <div class="flex flex-row justify-between gap-1 w-full">
                <h2>
                    Confirm A Payment
                </h2>
                <button class="btn btn-circle" @click="closeModal" type="button">
                    <X class="text-gray-700" size="22" />
                </button>
            </div>
        </template>
        <template #content>
            <form @submit.prevent="submit" class="prose">
                <div>
                    <img class="max-h-[110px] mx-auto rounded-md" src="/storage/uploads/GSB.jpg" alt="GSB" />
                    <h3 class="text-center">Bank GSB</h3>
                    <h3 class="text-center">Bank Number 020166916765</h3>
                    <h3 class="text-center">Name Chacrit Poonpipit</h3>
                    <h3 class="text-center">
                        Total Price
                        {{ totalPrice }} $
                    </h3>
                </div>

                <div class="mb-3">
                    <label class="label" for="slip_image">Slip</label>
                    <input id="slip_image" @change="handlePhoto" class="input" type="file" accept="image/*" />
                    <InputError class="mt-2" :message="form.errors.slip_image" />
                </div>

                <div v-if="form.slip_image" class="mb-3">
                    <img class="max-h-[180px] rounded-lg border border-gray-300" :src="'/storage/' + form.slip_image"
                        alt="image preview" />
                </div>

                <div class="flex justify-end mt-2">
                    <button :disabled="loading || form.processing" class="btn btn-primary" type="submit">
                        Confirm
                    </button>
                </div>
            </form>
        </template>
    </DialogModal>
</template>
