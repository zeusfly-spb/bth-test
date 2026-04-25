<template>
    <v-app>
        <v-app-bar app>
            <v-app-bar-title>BTH-TEST</v-app-bar-title>
        </v-app-bar>
        <v-main>
            <v-container fluid>
                <slot />
            </v-container>
        </v-main>
        <footer class="app-layout__footer">
            <slot name="footer">
                <small>&copy; 2026 Сайфутдинов О.А. </small>
            </slot>
        </footer>
    </v-app>
</template>

<script setup>
</script>

<style scoped>
.app-layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #f7f7f8;
    color: #1f2937;
}

.app-layout__header,
.app-layout__footer {
    padding: 1rem 1.5rem;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
}

.app-layout__footer {
    margin-top: auto;
    border-bottom: 0;
    border-top: 1px solid #e5e7eb;
}

.app-layout__title {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
}

.app-layout__content {
    width: 100%;
    margin: 0;
    padding: 1.5rem;
    text-align: left;
}
</style>
