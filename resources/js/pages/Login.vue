<template>
    <v-app class="login-page">
        <Head title="Вход" />
        <v-main class="login-page__main">
            <v-container class="fill-height d-flex align-center justify-center">
                <v-card class="login-card" elevation="12" rounded="xl">
                    <v-card-text class="pa-8">
                        <div class="text-center mb-7">
                            <p class="text-overline text-primary mb-2">BTH-TEST</p>
                            <h1 class="text-h5 font-weight-bold mb-2">Вход в аккаунт</h1>
                            <p class="text-medium-emphasis">
                                Введите email и пароль для доступа в систему.
                            </p>
                        </div>

                        <v-form @submit.prevent="handleSubmit">
                            <v-text-field
                                v-model="form.email"
                                placeholder="Email"
                                type="email"
                                name="email"
                                variant="outlined"
                                prepend-inner-icon="mdi-email-outline"
                                autocomplete="email"
                                persistent-placeholder
                                density="comfortable"
                                class="mb-3"
                                :rules="[rules.required, rules.email]"
                            />

                            <v-text-field
                                v-model="form.password"
                                placeholder="Пароль"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                variant="outlined"
                                prepend-inner-icon="mdi-lock-outline"
                                :append-inner-icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'"
                                autocomplete="current-password"
                                persistent-placeholder
                                density="comfortable"
                                class="mb-2"
                                :rules="[rules.required]"
                                @click:append-inner="showPassword = !showPassword"
                            />

                            <v-btn
                                type="submit"
                                block
                                color="primary"
                                size="large"
                                rounded="lg"
                            >
                                Войти
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
        <v-snackbar
            v-model="snackbar.show"
            :color="snackbar.color"
            :timeout="snackbar.timeout"
            location="top"
        >
            {{ snackbar.text }}
            
            <template v-slot:actions>
            <v-btn
                variant="text"
                icon="mdi-close"
                @click="snackbar.show = false"
            />
            </template>
        </v-snackbar>
    </v-app>
</template>

<script setup>
import { Head, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { useApi } from "../composables/useApi";

const api = useApi();
const showPassword = ref(false);
const form = reactive({
    email: "",
    password: "",
});

const rules = {
    required: (value) => !!value || "Поле обязательно для заполнения",
    email: (value) =>
        /.+@.+\..+/.test(value) || "Введите корректный email",
};

const snackbar = reactive({
    show: false,
    text: '',
    color: 'error',
    timeout: 1500,
});

function showError(message) {
    snackbar.text = message;
    snackbar.color = 'error';
    snackbar.show = true;
};

async function handleSubmit() {
    try {
        const {data: {token}} = await api.post('/login', form);
        localStorage.setItem('token', token);   
        router.get('/admin');
    } catch (e) {
        const errorMessage = getErrorMessage(e);
        showError(errorMessage);
    }
};

function getErrorMessage(error) {
    if (!error.response) {
        return 'Нет соединения с сервером. Проверьте интернет.';
    }
    
    if (error.response.status === 401) {
        return 'Неверный логин или пароль';
    }
    
    if (error.response.status === 403) {
        return 'Доступ запрещен';
    }
    
    if (error.response.status === 404) {
        return 'Сервис временно недоступен';
    }
    
    return error.response.data?.message || 
           error.response.data?.error || 
           'Произошла ошибка. Попробуйте еще раз.';
};

</script>

<style scoped>
.login-page {
    background: radial-gradient(circle at top left, #dbeafe, #f8fafc 45%, #eef2ff);
}

.login-page__main {
    min-height: 100vh;
}

.login-card {
    width: 100%;
    max-width: 470px;
    border: 1px solid rgba(99, 102, 241, 0.14);
    backdrop-filter: blur(2px);
}

.login-card__link {
    font-size: 0.875rem;
    color: rgb(var(--v-theme-primary));
    text-decoration: none;
}

.login-card__link:hover {
    text-decoration: underline;
}
</style>