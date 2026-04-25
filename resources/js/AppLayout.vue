<template>
    <div class="app-layout">
        <header class="app-layout__header">
            <slot name="header">
                <h1 class="app-layout__title">BTH Test</h1>
            </slot>
        </header>

        <main class="app-layout__content">
            <slot />
        </main>

        <footer class="app-layout__footer">
            <slot name="footer">
                <small>Inertia + Vue</small>
            </slot>
        </footer>
    </div>
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
