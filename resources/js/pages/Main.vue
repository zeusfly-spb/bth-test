<template>
    <AppLayout>
        <Head title="Главная" />

        <v-row justify="end">
            <v-col cols="3">
                <v-select
                    v-model="selectedCategoryId"
                    :items="categories"
                    item-title="name"
                    item-value="id"
                    label="Категория"
                    variant="outlined"
                />
            </v-col>            
        </v-row>

        <v-card title="Товары">
            <v-card-text>
                <v-data-table
                    :items="products"
                    :headers="tableHeaders"
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
import { ref, computed, toRefs } from "vue";
import { useApi } from "../composables/useApi";

const props = defineProps({rawProducts: Object});
const {rawProducts} = toRefs(props);
const api = useApi();
const tableHeaders = ref([
    {title: '#', key: 'id', sortable: true},
    {title: 'Наименование' , key: 'name', sortable: true},
    {title: 'Описание' , key: 'description', sortable: false},
    {title: 'Цена' , key: 'price', sortable: true},
    {title: 'Категория' , key: 'category', sortable: true,   value: item => item.category?.name},
]);
const rawCategories = ref([]);
const selectedCategoryId = ref(0);

const categories = computed(() => {
    return [{id: 0, name: 'Все категории'}, ...rawCategories.value ?? []];
});
const products = computed(() => {
    if (selectedCategoryId.value === 0) {
        return rawProducts.value.data;
    }
    return rawProducts.value.data.filter(product => product.category?.id === selectedCategoryId.value);
});
async function getCategories() {
    const {data} = await api.get('/categories');
    rawCategories.value = data;
};

getCategories();

</script>
