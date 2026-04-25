<template>
    <AdminLayout>
        <Head title="Редактирование товара" />
        <div class="page-shell">
            <v-card
                class="page-card"
                rounded="xl"
                elevation="12"
            >
                <v-card-title class="text-h6 py-4">
                    Редактирование товара
                </v-card-title>
                <v-divider />
                <v-card-text class="pt-6">
                    <v-skeleton-loader
                        v-if="isLoading"
                        type="article, list-item-three-line"
                    />

                    <v-form
                        v-else
                        ref="formRef"
                        @submit.prevent="submit"
                    >
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    v-model.trim="form.name"
                                    label="Название"
                                    variant="outlined"
                                    rounded="lg"
                                    :rules="nameRules"
                                    maxlength="255"
                                    counter
                                    required
                                />
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-select
                                    v-model="form.category_id"
                                    :items="categories"
                                    item-title="name"
                                    item-value="id"
                                    label="Категория"
                                    variant="outlined"
                                    rounded="lg"
                                    :rules="categoryRules"
                                    required
                                />
                            </v-col>

                            <v-col cols="12">
                                <v-textarea
                                    v-model.trim="form.description"
                                    label="Описание"
                                    variant="outlined"
                                    rounded="lg"
                                    rows="4"
                                    maxlength="255"
                                    counter
                                />
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-text-field
                                    v-model.number="form.price"
                                    label="Цена, р."
                                    type="number"
                                    min="1"
                                    step="1"
                                    variant="outlined"
                                    rounded="lg"
                                    :rules="priceRules"
                                    required
                                />
                            </v-col>
                        </v-row>

                        <v-alert
                            v-if="errorText"
                            type="error"
                            variant="tonal"
                            class="mb-4"
                        >
                            {{ errorText }}
                        </v-alert>

                        <div class="d-flex flex-wrap ga-3">
                            <v-btn
                                type="submit"
                                color="primary"
                                class="save-btn"
                                :loading="isSaving"
                                :disabled="isSaving || isLoading || !isDirty"
                            >
                                Сохранить изменения
                            </v-btn>
                            <v-btn
                                variant="outlined"
                                color="secondary"
                                href="/admin"
                            >
                                Отмена
                            </v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>

            <v-snackbar
                v-model="showSuccessToast"
                color="success"
                location="top right"
                timeout="1800"
            >
                Изменения успешно сохранены
            </v-snackbar>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, reactive, toRefs, computed } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import AdminLayout from '../AdminLayout.vue';
import { useApi } from '../composables/useApi';

const props = defineProps({ id: { type: Number, required: true } });
const { id } = toRefs(props);
const api = useApi();
const categories = ref([]);
const isLoading = ref(true);
const isSaving = ref(false);
const errorText = ref('');
const showSuccessToast = ref(false);
const formRef = ref(null);
const initialForm = ref(null);

const form = reactive({
    name: '',
    description: '',
    price: null,
    category_id: null,
});

const normalizedForm = computed(() => ({
    name: (form.name ?? '').trim(),
    description: (form.description ?? '').trim(),
    price: Number(form.price),
    category_id: form.category_id,
}));

const isDirty = computed(() => {
    if (!initialForm.value) {
        return false;
    }

    return JSON.stringify(normalizedForm.value) !== JSON.stringify(initialForm.value);
});

const nameRules = [
    (v) => !!v || 'Введите название товара',
];
const categoryRules = [
    (v) => !!v || 'Выберите категорию',
];
const priceRules = [
    (v) => v !== null && v !== '' || 'Введите цену',
    (v) => Number(v) >= 1 || 'Минимальная цена: 1',
];

async function getProduct() {
    const { data } = await api.get(`/products/${id.value}`);
    form.name = data?.name ?? '';
    form.description = data?.description ?? '';
    form.price = data?.price ?? null;
    form.category_id = data?.category?.id ?? null;
    initialForm.value = {
        name: (form.name ?? '').trim(),
        description: (form.description ?? '').trim(),
        price: Number(form.price),
        category_id: form.category_id,
    };
}

async function getCategories() {
    const { data } = await api.get('/categories');
    categories.value = data ?? [];
}

async function submit() {
    errorText.value = '';
    if (!isDirty.value) {
        return;
    }

    const { valid } = await formRef.value.validate();
    if (!valid) {
        return;
    }

    try {
        isSaving.value = true;
        await api.put(`/products/${id.value}`, {
            name: form.name,
            description: form.description,
            price: Number(form.price),
            category_id: form.category_id,
        });
        showSuccessToast.value = true;
        initialForm.value = { ...normalizedForm.value };
        setTimeout(() => {
            router.get('/admin');
        }, 700);
    } catch (error) {
        const backendMessage = error?.response?.data?.message;
        errorText.value = backendMessage || 'Не удалось сохранить изменения. Попробуйте ещё раз.';
    } finally {
        isSaving.value = false;
    }
}

async function initPage() {
    try {
        await Promise.all([getProduct(), getCategories()]);
    } catch (error) {
        errorText.value = 'Не удалось загрузить данные товара.';
    } finally {
        isLoading.value = false;
    }
}

initPage();
</script>
