<script setup>
import { X, CirclePlus, CircleMinus } from "lucide-vue-next";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import axios from "axios";
defineProps({
    shoeSizes: Object,
});
const loading = ref(false);
const formData = ref(new FormData());
const form = useForm({
    name: "",
    description: "",
    price: "",
    size: "",
    type: "",
    variants: [
        {
            color: {
                name: "",
                photo_url: "",
            },
            sizes: [

            ],
        },

    ],
});
const store = () => {
    form.post(route("admin.shoe.store"), {
        onSuccess: () => {
            form.reset();
        },
    });
};
const handlePhoto = (event, variantIndex) => {
    const file = event.target.files[0];
    formData.value.append("photo_url", file);
    uploadPhoto(formData.value, variantIndex);
};
const uploadPhoto = (formData, variantIndex) => {
    loading.value = true;

    axios
        .post("/upload", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            form.variants[variantIndex].color.photo_url = response.data.path;
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
const addVariant = () => {
    form.variants.push({
        color: {
            name: "",
            photo_url: "",
        },
        sizes: [],
    });
};
const deleteVariant = () => {
    form.variants.splice(form.variants.length - 1, 1);
};
const addSize = (variantIndex) => {
    const sizeExists = form.variants[variantIndex].sizes.some(
        (sizeObj) => sizeObj.size === form.size
    );

    if (!sizeExists && form.size != "") {
        form.variants[variantIndex].sizes.push({
            size: form.size,
            stock: "",
        });
    }
};
const deleteSize = (variantIndex) => {
    const sizes = form.variants[variantIndex].sizes;
    sizes.splice(sizes.length - 1, 1);
};
</script>

<template>
    <AdminLayout title="Dashboard">
        <div class="p-6 space-y-2">
            <form @submit.prevent="store">
                <div class="mb-3">
                    <label class="label" for="name">name</label>
                    <input id="name" v-model="form.name" class="input" type="text"
                        placeholder="Classic Leather Sneakers" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-3">
                    <label class="label" for="description">description</label>
                    <textarea class="input" v-model="form.description" id="description" rows="5"
                        placeholder="White leather sneakers with a classic design.">
                    </textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="mb-3">
                    <label class="label" for="price">price</label>
                    <input id="price" v-model="form.price" class="input" type="text"
                        placeholder="Classic Leather Sneakers" />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div class="mb-3">
                    <label class="label" for="type">type</label>
                    <select v-model="form.type" class="input">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="All">All</option>
                    </select>
                </div>

                <div class="mb-3 flex flex-col gap-1">
                    <div v-for="(variant, variantIndex) in form.variants">
                        <div class="mb-2">
                            <label class="label" :for="'variant' + variant">
                                variant {{ variantIndex + 1 }}
                            </label>
                            <div class="pl-6">
                                <div class="mb-2">
                                    <label class="label" :for="'color' + variant.id">
                                        color
                                    </label>
                                    <input :id="'color' + variant.id" v-model="form.variants[variantIndex].color
                .name
                " class="input" type="text" placeholder="Red" />
                                    <InputError class="mt-2" :message="form.errors[
                'variants.' +
                variantIndex +
                '.color.name'
            ]
                " />
                                </div>
                                <div class="mb-3">
                                    <label class="label" :for="'photo_url' + variant.id">photo</label>
                                    <input :id="'photo_url' + variant.id" @change="
                handlePhoto($event, variantIndex)
                " class="input" type="file" accept="image/*" />
                                    <InputError class="mt-2" :message="form.errors[
                'variants.' +
                variantIndex +
                '.color.photo_url'
            ]
                " />
                                </div>

                                <div v-if="form.variants[variantIndex].color
                .photo_url
                " class="mb-3">
                                    <img class="max-h-[200px] rounded-lg border border-gray-300" :src="'/storage/' +
                form.variants[variantIndex].color
                    .photo_url
                " alt="image preview" />
                                </div>

                                <div class="mb-2">
                                    <label class="label" for="sizes">
                                        sizes
                                    </label>
                                    <select v-model="form.size" class="input mb-3">
                                        <template v-for="size in shoeSizes" :key="size">
                                            <option :value="size">
                                                {{ size }}
                                            </option>
                                        </template>
                                    </select>
                                    <div class="flex flex-row mb-2">
                                        <button @click="addSize(variantIndex)" type="button"
                                            class="btn btn-secondary btn-sm flex items-center gap-2">
                                            <CirclePlus size="20" />
                                            <span> Add Size </span>
                                        </button>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <template v-for="(size, sizeIndex) in form
                .variants[variantIndex].sizes">
                                            <div class="mb-2">
                                                <label class="label">
                                                    Stock for size
                                                    {{ size.size }}
                                                </label>
                                                <input class="input" type="text" v-model="form.variants[
                variantIndex
            ].sizes[sizeIndex][
                'stock'
            ]
                " />
                                                <InputError class="mt-2" :message="form.errors[
                'variants.' +
                variantIndex +
                '.sizes.' +
                sizeIndex +
                '.stock'
            ]
                " />
                                            </div>
                                        </template>
                                        <button v-if="form.variants[variantIndex]
                .sizes.length >= 1
                " @click="deleteSize(variantIndex)" type="button"
                                            class="btn btn-danger btn-sm flex items-center gap-2">
                                            <CircleMinus size="20" />
                                            <span> Delete Last Size </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button @click="addVariant" type="button" class="btn btn-warning btn-sm flex items-center gap-2">
                        <CirclePlus size="20" />
                        <span> Add Variant </span>
                    </button>
                    <button v-if="form.variants.length >= 2" @click="deleteVariant" type="button"
                        class="btn btn-danger btn-sm flex items-center gap-2">
                        <CirclePlus size="20" />
                        <span> Remove Last Variant </span>
                    </button>
                </div>

                <div class="flex justify-end mt-2">
                    <button :disabled="loading || form.processing" class="btn btn-primary" type="submit">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
