<template>
    <div class="ms-container">
        <Accomodations />
    </div>
</template>

<script>
import Accomodations from "../components/Accomodations.vue";
export default {
    name: "Home",
    components: {
        Accomodations,
    },
};
</script>

<style lang="scss" scoped>
  h1 {
    color: white;
    font-size: 4.5rem;
    margin-top: calc(25% - 50px);
    margin-left: 2rem;
  }
</style>