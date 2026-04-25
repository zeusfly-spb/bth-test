<template>
    <AppLayout>
        <Head 
            :title="product?.name" 
        />
        <div class="page-shell">
            <v-row class="mb-4">
                <v-col cols="12">
                    <Link
                        href="/"
                        class="text-decoration-none page-back"
                        v-bind="props"
                    >
                        <v-icon size="20">mdi-arrow-left</v-icon>
                        <span>К списку товаров</span>
                    </Link>
                </v-col>
            </v-row>
            <v-card
                :title="product?.name"
                class="page-card"
                rounded="xl"
                elevation="12"
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
        </div>
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
