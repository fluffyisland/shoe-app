<script setup>
import { onMounted, ref } from "vue";
import { Link, router, useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { CircleCheck } from "lucide-vue-next";

const props = defineProps({
    user: Object,
});

const form = useForm({
    address: "",
});
const selectedAddress = ref("");
const store = () => {
    form.post(route("customer.address.store"), {
        preserveScroll: true,
    });
};
const addressUser = ref(null);
const setAddress = (address) => {
    selectedAddress.value = address;
};
const update = () => {
    form.put(route("customer.address.update", selectedAddress.value.id), {
        preserveScroll: true,
    });
};
onMounted(() => {
    axios
        .get(route("customer.address.store"))
        .then((res) => {
            addressUser.value = res.data.address;
            console.log(res.data.address);
        })
        .catch((error) => {
            console.log(error);
        });
});
</script>

<template>
    <FormSection @submitted="store">
        <template #title> Address Information </template>

        <template #description>
            Update your account's address information.
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="address" value="Address" />
                <textarea
                    rows="8"
                    id="address"
                    v-model="form.address"
                    class="input"
                ></textarea>
                <InputError :message="form.errors.address" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <button
                class="btn btn-primary"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Add Address
            </button>
        </template>
    </FormSection>
    <FormSection @submitted="update">
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <h1 class="text-lg mb-2">Select Address</h1>
                <template v-for="address in addressUser" :key="address.id">
                    <button
                        @click="setAddress(address)"
                        :class="
                            selectedAddress.id == address.id
                                ? 'bg-blue-500 text-white border-blue-400'
                                : 'bg-white hover:bg-gray-300 border-gray-400'
                        "
                        type="button"
                        class="p-3 border w-full rounded-md text-start mt-2 flex items-center justify-between"
                    >
                        {{ address.address }}
                        <span v-if="user.current_address_id == address.id">
                            <CircleCheck color="white" />
                        </span>
                    </button>
                </template>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
