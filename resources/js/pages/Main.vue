<template>
    <AppLayout>
        <Head title="Главная" />

        <v-row justify="end">
            <v-col cols="2">
                <v-select
                    v-model="selectedCategoryId"
                    :items="categories"
                    item-title="name"
                    item-value="id"
                    label="Категория"
                    variant="outlined"
                    @update:model-value="getProducts"
                />
            </v-col>            
        </v-row>

        <v-card title="Товары">
            <v-card-text>
                <v-data-table
                    :items="products.data"
                    :headers="tableHeaders"
                    no-data-text="Товары не найдены"
                    hide-default-footer
                    hover
                    @click:row="rowClick"
                >
                    <template #bottom>
                        <div class="d-flex justify-center pa-4">
                            Всего товаров: {{ products?.meta?.total }} Показаны: с {{ products?.meta?.from }} по {{ products?.meta?.to }}
                        </div>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-pagination 
                :length="(meta?.last_page ?? 1)" 
                v-model="currentPage"
                :total-visible="7"
            />
        </v-card>
        
    </AppLayout>   
</template>

<script setup>
import AppLayout from "../AppLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import { useApi } from "../composables/useApi";

const api = useApi();

const tableHeaders = ref([
    {title: '#', key: 'id', sortable: true},
    {title: 'Наименование' , key: 'name', sortable: true},
    {title: 'Описание' , key: 'description', sortable: false},
    {title: 'Цена (р.)' , key: 'price', sortable: true},
    {title: 'Категория' , key: 'category', sortable: true,   value: item => item.category?.name},
]);
const rawCategories = ref([]);
const products = ref({});
const selectedCategoryId = ref(0);
const currentPage = ref(1);

const categories = computed(() => {
    return [{id: 0, name: 'Все категории'}, ...rawCategories.value ?? []];
});
const meta = computed(() => {
    return products.value.meta;
});

async function getCategories() {
    const {data} = await api.get('/categories');
    rawCategories.value = data;
};
async function getProducts() {
    const {data} = await api.get('/products', {params: {page: currentPage.value, category_id: selectedCategoryId.value}});
    products.value = data;
};
function rowClick(_, row) {
    console.log(row.internalItem.key);
    router.get(`/products/${row.internalItem.key}`)
};

watch(currentPage, () => {
    getProducts();
}, {immediate: true});
watch(selectedCategoryId, () => {
    currentPage.value = 1;
}, {immediate: true});

getCategories();
getProducts();
</script>
