<template>
    <header class="container-fluid">
        <nav class="nav">
            <router-link
                class="logo-container"
                aria-current="page"
                :to="{ name: 'home' }"
            >
                <h4 class="pippo">Bool BnB</h4>
            </router-link>
            <!-- <router-link
                class="logo-container"
                aria-current="page"
                :to="{ name: 'blog' }"
            >
                <h4 class="pippo">Lista appartamenti</h4>
            </router-link> -->
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
    height: 80px;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    z-index: 1;

    .pippo {
        padding: 0 2rem;
        line-height: 80px;
    }

    .pippo:hover {
        text-decoration: underline;
        // text-transform: uppercase;
        color: white;
    }

    .ms_searchbar {
        width: 50%;
        text-align: center;
        line-height: 80px;
        select {
            width: 150px;
            height: 30px;
            border-radius: 50px;
            border: none;
        }
        input {
            width: 500px;
            height: 30px;
            padding: 1rem;
            border-radius: 50px;
            border: none;
        }
    }
}
</style>
