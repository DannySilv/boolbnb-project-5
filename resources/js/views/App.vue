<template>
    <div id="app">
        <Header />
        <!-- <Home /> -->
        <router-view></router-view>
    </div>
</template>

<script>
import Header from "../components/Header.vue";
// import Home from '../components/Home.vue';

export default {
    name: "App",
    components: {
        Header,
        // Home,
    },
};
</script>

<style>
@import "../style/style.scss";

#app {
    width: 100%;
    height: 100vh;
    background-color: rgb(54, 54, 54);
}
</style>
