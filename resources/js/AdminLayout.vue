<template>
    <v-app>
        <v-app-bar
                density="comfortable"
            >
                <template v-slot:append>
                    <v-btn 
                        icon="mdi-logout"
                        title="Выход" 
                        @click="logout" 
                    />
                </template>

                <v-app-bar-title>
                    Административная панель
                </v-app-bar-title>
            </v-app-bar>
        <v-main
            v-if="authorized"
        >
            <v-container fluid>
                <slot />
            </v-container>
        </v-main>
        <footer class="app-layout__footer">
            <slot name="footer">
                <small>&copy; 2026 Сайфутдинов О.А.</small>
            </slot>
        </footer>
    </v-app>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
const authorized = ref(false);

const token = localStorage.getItem('token');
if (!token) {
    router.get('/login');
} else {
    authorized.value = true;
}

function logout() {
    localStorage.removeItem('token');
    router.get('/login');
};
</script>

<style scoped>
.app-layout__footer {
    padding: 1rem 1.5rem;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    border-bottom: 0;
    border-top: 1px solid #e5e7eb;
}
</style>
