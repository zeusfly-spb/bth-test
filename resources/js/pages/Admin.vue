<template>
    <AdminLayout>
        <Head title="Управление товарами" />
        <div 
            class="page-shell"
        >
            <v-row 
                justify="space-between"
                align="end" 
                class="mb-3"
            >
                <v-col
                    cols="6"
                    md="4"
                    lg="3"
                >
                    <v-btn
                        class="ml-1"
                        color="primary"
                        @click="addProduct"
                    >
                        Добавить товар
                    </v-btn>
                </v-col>
          
                <v-col cols="6" md="4" lg="3">
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
            <v-card 
                class="page-card" 
                title="Управление товарами" 
                rounded="xl" 
                elevation="12"
            >
                <v-card-text>
                    <v-data-table
                        :items="products.data"
                        :headers="tableHeaders"
                        no-data-text="Товары не найдены"
                        hide-default-footer
                        hover
                    >
                        <template #item.actions="{ item }">
                            <v-btn
                                size="small"
                                color="primary"
                                @click="editProduct(item)"
                                class="mr-2"
                            >
                                Редактировать
                            </v-btn>
                            <v-btn
                                size="small"
                                color="error"
                                @click="deleteProduct(item)"
                            >
                                Удалить
                            </v-btn>
                        </template>
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
            <v-dialog
                v-model="showDeleteConfirm"
                max-width="420"
            >
                <v-card rounded="lg">
                    <v-card-title class="text-h6">
                        Подтвердите удаление
                    </v-card-title>
                    <v-card-text>
                        Вы уверены, что хотите удалить товар "{{ productToDelete?.name }}"?
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            variant="text"
                            @click="closeDeleteDialog"
                        >
                            Отмена
                        </v-btn>
                        <v-btn
                            color="error"
                            :loading="isDeleting"
                            :disabled="isDeleting"
                            @click="confirmDeleteProduct"
                        >
                            Удалить
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-snackbar
                v-model="showDeleteSuccessToast"
                color="success"
                location="top right"
                timeout="1800"
            >
                Товар успешно удалён
            </v-snackbar>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "../AdminLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import { useApi } from "../composables/useApi";

const api = useApi();
const rawCategories = ref([]);
const products = ref({});
const currentPage = ref(1);
const selectedCategoryId = ref(0);
const showDeleteConfirm = ref(false);
const productToDelete = ref(null);
const isDeleting = ref(false);
const showDeleteSuccessToast = ref(false);
const tableHeaders = ref([
    {title: '#', key: 'id', sortable: true},
    {title: 'Наименование' , key: 'name', sortable: true},
    {title: 'Описание' , key: 'description', sortable: false},
    {title: 'Цена (р.)' , key: 'price', sortable: true},
    {title: 'Категория' , key: 'category', sortable: true,   value: item => item.category?.name},
    {title: 'Управление', key: 'actions'}
]);

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

function addProduct() {
    router.get('/admin/products/create');
};

function editProduct(item) {
    router.get(`/admin/products/${item.id}/edit`);
};

function deleteProduct(item) {
    productToDelete.value = item;
    showDeleteConfirm.value = true;
};

function closeDeleteDialog() {
    showDeleteConfirm.value = false;
    productToDelete.value = null;
};

async function confirmDeleteProduct() {
    if (!productToDelete.value?.id) {
        return;
    }

    try {
        isDeleting.value = true;
        await api.delete(`/products/${productToDelete.value.id}`);
        showDeleteSuccessToast.value = true;
        closeDeleteDialog();
        setTimeout(() => {
            router.get('/admin');
        }, 700);
    } finally {
        isDeleting.value = false;
    }
};

watch(currentPage, () => {
    getProducts();
}, {immediate: true});

getCategories();
getProducts();
</script>