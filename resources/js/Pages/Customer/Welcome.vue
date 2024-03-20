<script setup>
import { Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CustomerLayout from "@/Layouts/CustomerLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { ArrowDownWideNarrow } from "lucide-vue-next";
const props = defineProps({
    shoes: Object,
});
const type = ref("All");
const setMale = () => {
    type.value = "Male";
};
const setFeMale = () => {
    type.value = "Female";
};
const setAll = () => {
    type.value = "All";
};

const filteredShoes = computed(() => {
    if (type.value === "All") {
        return props.shoes;
    } else {
        return props.shoes.filter((shoe) => shoe.type === type.value);
    }
});
</script>

<template>
    <CustomerLayout title="Welcome">
        <h1>Welcome</h1>
        <div class="my-4 w-fit">
            <Dropdown align="left" width="48">
                <template #trigger>
                    <button class="btn btn-light flex gap-1">
                        <span> Type </span>
                        <ArrowDownWideNarrow size="20" />
                    </button>
                </template>

                <template #content>
                    <DropdownLink @click="setMale" as="button">
                        Male
                    </DropdownLink>

                    <DropdownLink @click="setFeMale" as="button">
                        Female
                    </DropdownLink>

                    <DropdownLink @click="setAll" as="button">
                        All
                    </DropdownLink>
                </template>
            </Dropdown>
        </div>
        <div class="grid lg:grid-cols-4 grid-cols-5 gap-y-10">
            <template v-for="shoe in filteredShoes" :key="shoe.id">
                <Link
                    :href="
                        route('customer.welcome.show', {
                            id: shoe.id,
                        })
                    "
                    class="space-y-3"
                >
                    <img
                        class="max-w-[300px] border border-gray-200 hover:scale-[101%]"
                        :src="'/storage/' + shoe.shoe_colors[0].photo_url"
                        :alt="shoe.name"
                    />
                    <h1 class="text-blue-600 text-4xl font-bold">
                        ฿{{ shoe.price }}
                    </h1>
                    <h2 class="text-2xl font-lg font-semibold">
                        {{ shoe.name }}
                        <span class="text-xs text-gray-700">
                            ({{ shoe.type }})
                        </span>
                    </h2>
                </Link>
            </template>
        </div>
    </CustomerLayout>
</template>
