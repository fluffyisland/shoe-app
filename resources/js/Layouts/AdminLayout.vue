<script setup>
import { Link, router } from "@inertiajs/vue3";
import { CircleGauge, Footprints, Receipt, UsersRound } from "lucide-vue-next";
import AppLayout from "./AppLayout.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
defineProps({
    title: String,
});
const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <AppLayout :title="title">
        <main
            class="min-h-screen max-h-screen overflow-y-hidden grid grid-cols-12"
        >
            <aside class="col-span-2 bg-blue-600">
                <h1 class="text-3xl font-semibold text-white p-6">ADMIN</h1>
                <ul>
                    <li
                        class="transition-colors"
                        :class="
                            route().current() == 'admin.dashboard.index'
                                ? 'bg-blue-700 '
                                : 'hover:bg-blue-700 cursor-pointer'
                        "
                    >
                        <Link
                            :href="route('admin.dashboard.index')"
                            :class="{
                                'cursor-default':
                                    route().current() ==
                                    'admin.dashboard.index',
                            }"
                            class="py-4 pl-6 text-white font-semibold block"
                        >
                            <div class="flex items-center gap-3">
                                <CircleGauge />
                                <span> Dashboard </span>
                            </div>
                        </Link>
                    </li>
                    <li
                        class="transition-colors"
                        :class="
                            route().current() == 'admin.shoe.index'
                                ? 'bg-blue-700 '
                                : 'hover:bg-blue-700 cursor-pointer'
                        "
                    >
                        <Link
                            :href="route('admin.shoe.index')"
                            :class="{
                                'cursor-default':
                                    route().current() == 'admin.shoe.index',
                            }"
                            class="py-4 pl-6 text-white font-semibold block"
                        >
                            <div class="flex items-center gap-3">
                                <Footprints />
                                <span> Shoes </span>
                            </div>
                        </Link>
                    </li>
                    <li
                        class="transition-colors"
                        :class="
                            route().current() == 'admin.order.index'
                                ? 'bg-blue-700 '
                                : 'hover:bg-blue-700  cursor-pointer'
                        "
                    >
                        <Link
                            :href="route('admin.order.index')"
                            :class="{
                                'cursor-default':
                                    route().current() == 'admin.order.index',
                            }"
                            class="py-4 pl-6 text-white font-semibold block"
                        >
                            <div class="flex items-center gap-3">
                                <Receipt />
                                <span> Orders </span>
                            </div>
                        </Link>
                    </li>
                    <li
                        class="transition-colors"
                        :class="
                            route().current() == 'admin.customer.index'
                                ? 'bg-blue-700'
                                : 'hover:bg-blue-700  cursor-pointer'
                        "
                    >
                        <Link
                            :href="route('admin.customer.index')"
                            :class="{
                                'cursor-default':
                                    route().current() == 'admin.customer.index',
                            }"
                            class="py-4 pl-6 text-white font-semibold block"
                        >
                            <div class="flex items-center gap-3">
                                <UsersRound />
                                <span> Customers </span>
                            </div>
                        </Link>
                    </li>
                </ul>
            </aside>
            <section class="col-span-10">
                <div
                    class="p-6 bg-white flex justify-end border-b border-gray-300 shadow-md"
                >
                    <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                                >
                                    <img
                                        class="h-8 w-8 rounded-full object-cover"
                                        :src="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                        :alt="$page.props.auth.user.name"
                                    />
                                </button>

                                <span v-else class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="ms-2 -me-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div
                                    class="block px-4 py-2 text-xs text-gray-400"
                                >
                                    Manage Account
                                </div>

                                <DropdownLink :href="route('profile.show')">
                                    Profile
                                </DropdownLink>

                                <div class="border-t border-gray-200" />

                                <form @submit.prevent="logout">
                                    <DropdownLink as="button">
                                        Log out
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                </div>
                <div class="bg-gray-100 h-screen overflow-y-scroll pb-[10rem]">
                    <slot />
                </div>
            </section>
        </main>
    </AppLayout>
</template>
