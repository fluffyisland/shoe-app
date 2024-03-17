<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdateAddressInformationForm from "@/Pages/Profile/Partials/UpdateAddressInformationForm.vue";
import { Check } from "lucide-vue-next";
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <UpdateProfileInformationForm
                        :user="$page.props.auth.user"
                    />

                    <SectionBorder />
                </div>
                <div>
                    <UpdateAddressInformationForm
                        :user="$page.props.auth.user"
                    />

                    <SectionBorder />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
