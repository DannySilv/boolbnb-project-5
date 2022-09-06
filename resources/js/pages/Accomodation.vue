<template>
    <div class="ms-container">
        <div class="card cardolina" style="width: 650px">
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
                <Map :accomodation="accomodation" />
            </div>
        </div>
        <!-- <section v-else>
            <h2>Loading</h2>
        </section> -->
    </div>
</template>

<script>
import Map from "../components/Map.vue";

export default {
    name: "Accomodation",
    components: {
        Map,
    },
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
    margin: 4rem auto;
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
