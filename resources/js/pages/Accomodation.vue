<template>
    <div class="ms-container">
        <section v-if="accomodation">
            <div class="card cardolina" style="width: 600px">
                <div v-if="accomodation.image">
                    <img
                        :src="accomodation.image"
                        class="card-img-top"
                        alt="Card image cap"
                    />
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ accomodation.name }}</h5>
                    <p>
                        {{ accomodation.description }}
                    </p>
                    <p>Stanze: {{ accomodation.n_rooms }}</p>
                    <p>Posti letto: {{ accomodation.n_beds }}</p>
                    <p>Bagni: {{ accomodation.n_bathrooms }}</p>
                    <p>Dimensione: {{ accomodation.size_sqm }} m²</p>
                    <p>Indirizzo: {{ accomodation.address }}</p>
                    <ul>
                        Servizi:
                        <li
                            v-for="(facility, idx) in accomodation.facilities"
                            :key="idx"
                        >
                            {{ facility.name }}
                        </li>
                    </ul>

                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </section>
        <!-- <section v-else>
            <h2>Loading</h2>
        </section> -->
    </div>
</template>

<script>
export default {
    name: "Accomodation",
    data() {
        return {
            accomodation: null,
        };
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
                    this.$router.push({ name: "not-found" });
                }
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.cardolina {
    padding-top: 4rem;
    margin-top: 4rem;
    margin-left: 10rem;
    p {
        font-weight: lighter;
    }
    li {
      display: inline-block;
      margin: 0 0.5rem;
      font-weight: lighter;
    }
}
</style>
