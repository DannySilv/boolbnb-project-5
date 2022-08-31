<template>
    <header class="container-fluid">
        <nav class="nav">
            <router-link
                class="logo-container"
                aria-current="page"
                :to="{ name: 'home' }"
            >
                <h5>Ciao</h5>
            </router-link>
        </nav>
    </header>
</template>

<script>
export default {
    name: "Header",
};
</script>

<style lang="scss" scoped>
header {
    width: 100%;
    height: 50px;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
}
</style>
