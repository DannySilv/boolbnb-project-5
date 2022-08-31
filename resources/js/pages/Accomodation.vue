<template>
  <div class="ms-container">
    <section v-if="accomodation">
      <h1>{{ accomodation.name }}</h1>
      <div v-if="accomodation.image">
        <img class="card-img-top" :src="accomodation.image" alt="Card image cap">
      </div>
      <p>{{ accomodation.description }}</p>
    </section>
    <section v-else>
      <h2>Loading</h2>
    </section>
  </div>
</template>

<script>
export default {
  name: "Accomodation",
  data() {
    return {
      accomodation: null
    }
  },
  created() {
    this.getAccomodationInfo();
  },
  methods: {
    getAccomodationInfo() {
      const slug = this.$route.params.slug;
      axios.get(`/api/accomodations/${slug}`).then((resp) => {
        if (resp.data.success) {
          this.accomodation = resp.data.results;
        } else {
          this.$router.push({ name: "not-found" })
        }
      });
    },
  },
}
</script>

<style>

</style>