<template>
    <div class="text-center text-black mt-5 not_found">
        <h1>Errore 404: Pagina non trovata!</h1>
        <router-link :to="{ name: 'home' }">
            Ritorna alla schermata iniziale
        </router-link>
    </div>
</template>

<script>
export default {
    name: "NotFound",
};
</script>

<style lang="scss" scoped>
    .not_found {
        padding-top: 200px;
        a {
            color: #ff385c;
        }
    }
</style>
