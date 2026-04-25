<template>
    <AppLayout>
        <Head title="Главная" />
        <v-card title="Товары">
            <v-card-text>
                <v-data-table
                    :items="products.data"
                    :headers="tableHeaders"
                    v-model:sort-by="sortBy"
                    hide-default-footer
                    hover 
                />
            </v-card-text>
        </v-card>
        
    </AppLayout>   
</template>

<script setup>
import AppLayout from "../AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({products: Object});
const tableHeaders = ref([
    {title: '#', key: 'id', sortable: true},
    {title: 'Наименование' , key: 'name', sortable: true},
    {title: 'Описание' , key: 'description', sortable: false},
    {title: 'Цена' , key: 'price', sortable: true},
    {title: 'Категория' , key: 'category', sortable: true,   value: item => item.category?.name},
]);
const sortBy = ref([]);
</script>