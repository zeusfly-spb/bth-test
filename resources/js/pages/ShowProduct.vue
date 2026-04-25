<template>
    <AppLayout>
        <Head 
            :title="product?.name" 
        />
        <v-row
            class="mb-2"
        >
            <v-tooltip
                text="Назад"
            >
                <template #activator="{ props }">
                    <Link 
                        href="/"
                        class="text-decoration-none"
                        v-bind="props"
                    >
                        <v-icon>mdi-arrow-left</v-icon>
                    </Link>
                </template>
            </v-tooltip>
        </v-row>
        <v-card
            :title="product?.name"
        >
            <v-list lines="two">
                <v-list-item
                    :title="`Описание: ${product?.description}`"
                    :subtitle="`Категория: ${product?.category?.name}`" 
                />
                <v-list-item
                    :title="`Цена: ${product?.price} р.`" 
                />
            </v-list>
        </v-card>
    </AppLayout>
</template>

<script setup>
import AppLayout from "../AppLayout.vue";
import { toRefs, ref } from 'vue';
import { useApi } from "../composables/useApi";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({id: {type: Number}});
const {id} = toRefs(props);
const api = useApi();
const product = ref(null);

async function getProduct() {
    const {data} = await api.get(`/products/${id.value}`);
    product.value = data;
}

getProduct();
</script>