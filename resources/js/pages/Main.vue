<template>
    <AppLayout>
        <Head title="Товары" />
        <div class="page-shell">
            <v-row justify="end" class="mb-3">
                <v-col cols="12" md="4" lg="3">
                    <v-select
                        v-model="selectedCategoryId"
                        :items="categories"
                        item-title="name"
                        item-value="id"
                        label="Категория"
                        variant="outlined"
                        bg-color="white"
                        rounded="lg"
                        hide-details
                        @update:model-value="getProducts"
                    />
                </v-col>
            </v-row>

            <v-card class="page-card" title="Товары" rounded="xl" elevation="12">
                <v-card-text>
                    <v-data-table
                        :items="products.data"
                        :headers="tableHeaders"
                        no-data-text="Товары не найдены"
                        hide-default-footer
                        hover
                        @click:row="rowClick"
                    >
                        <template 
                            #bottom
                            v-if="products?.meta?.total"
                        >
                            <div class="d-flex justify-center pa-4 text-medium-emphasis">
                                Всего товаров: {{ products?.meta?.total }} Показаны: с {{ products?.meta?.from }} по {{ products?.meta?.to }}
                            </div>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-pagination
                    :length="(meta?.last_page ?? 1)"
                    v-model="currentPage"
                    :total-visible="7"
                    class="pb-1"
                />
            </v-card>
        </div>
        
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

<style>
.page-shell {
    min-height: calc(100vh - 160px);
    padding: 1.25rem;
    border-radius: 1rem;
    background: radial-gradient(circle at top left, #dbeafe, #f8fafc 45%, #eef2ff);
}

.page-card {
    border: 1px solid rgba(99, 102, 241, 0.14);
}

.page-back {
    display: inline-flex;
    gap: 0.5rem;
    align-items: center;
    padding: 0.45rem 0.8rem;
    border-radius: 0.65rem;
    color: rgb(var(--v-theme-primary));
    background: rgba(255, 255, 255, 0.72);
    border: 1px solid rgba(99, 102, 241, 0.18);
}

.save-btn {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.save-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.28);
}
</style>
