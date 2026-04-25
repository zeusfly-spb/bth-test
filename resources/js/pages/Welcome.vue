<template>
    <AppLayout>
        <Head title="Welcome" />

        <template #header>
            <h1>Welcome page</h1>
        </template>

        <p>Hello from Vue + Inertia!</p>
    </AppLayout>
</template>

<script setup>
import AppLayout from "../AppLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>