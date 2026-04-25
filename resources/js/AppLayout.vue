<template>
    <v-app>
        <v-main>
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
