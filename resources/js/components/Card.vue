<template>
  <div class="card mb-4" style="height: 470px">
    <div v-if="accomodation.image">
      <img class="card-img-top" :src="accomodation.image" alt="Card image cap">
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ accomodation.name }}</h5>
        <p class="card-text">{{ truncateText(accomodation.description, 50) }}</p>
    </div>
    <div class="card-body">
        <router-link :to="{ name: 'accomodation', params: { slug: accomodation.slug } }" class="card-link btn btn-primary">Scopri di più</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "Card",
  props: {
    accomodation: Object,
  },
  methods: {
    truncateText(text, maxCharNumber) {
      if (text.length > maxCharNumber) {
          return text.substr(0, maxCharNumber) + "...";
      } else {
          return text;
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  a {
    // background-color: black;
  }

  img {
    width: 100%;
    height: 280px;
  }
</style>