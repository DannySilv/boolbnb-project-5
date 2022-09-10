<template>
    <div class="ms-container">
        <h2 class="text-center mt-5">
            Benvenuto! Comincia qui la tua ricerca!
        </h2>
        <div
            class="container-fluid d-flex justify-content-center align-items-center mb-3"
        >
            <SearchBar @searchedAccomodations="searchedAccomodations" />
        </div>
        <div v-if="homeAccomodations.length > 0" class="row row-cols-3">
            <div
                v-for="accomodation in homeAccomodations"
                :key="accomodation.id"
                class="col"
            >
                <div class="card mb-4" style="height: 470px">
                    <div v-if="accomodation.image">
                        <img
                            class="card-img-top"
                            :src="accomodation.image"
                            alt="Card image cap"
                        />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ accomodation.name }}</h5>
                        <p class="card-text">
                            {{ truncateText(accomodation.description, 50) }}
                        </p>
                    </div>
                    <div class="card-body">
                        <router-link
                            :to="{
                                name: 'accomodation',
                                params: { slug: accomodation.slug },
                            }"
                            class="card-link btn btn-primary"
                            >Scopri di più</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="row row-cols-3">
            <div
                v-for="accomodation in accomodations"
                :key="accomodation.id"
                class="col"
            >
                <div class="card mb-4" style="height: 470px">
                    <div v-if="accomodation.image">
                        <img
                            class="card-img-top"
                            :src="accomodation.image"
                            alt="Card image cap"
                        />
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ accomodation.name }}</h5>
                        <p class="card-text">
                            {{ truncateText(accomodation.description, 50) }}
                        </p>
                    </div>
                    <div class="card-body">
                        <router-link
                            :to="{
                                name: 'accomodation',
                                params: { slug: accomodation.slug },
                            }"
                            class="card-link btn btn-primary"
                            >Scopri di più</router-link
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SearchBar from "../components/SearchBar.vue";

export default {
    name: "Home",
    components: {
        SearchBar,
    },
    data() {
        return {
            accomodations: [],
            filteredAccomodations: [],
            searchKey: "",
        };
    },
    created() {
        this.getAccomodations();
    },
    computed: {
        homeAccomodations() {
            let newAccomodations = [];
            if (this.filteredAccomodations.length != 0) {
                this.filteredAccomodations.forEach((accomodation) => {
                    newAccomodations.push(accomodation);
                });
            }
            return newAccomodations;
        },
    },
    methods: {
        truncateText(text, maxCharNumber) {
            if (text.length > maxCharNumber) {
                return text.substr(0, maxCharNumber) + "...";
            } else {
                return text;
            }
        },
        searchedAccomodations(research) {
            this.filteredAccomodations = research;
        },
        getAccomodations() {
            axios
                .get("http://127.0.0.1:8000/api/accomodations")
                .then((resp) => {
                    this.accomodations = resp.data.appResults;
                });
        },
    },
};
</script>

<style lang="scss" scoped>
@import "../style/style.scss";

h1 {
    color: white;
    font-size: 4.5rem;
    margin-top: calc(25% - 50px);
    margin-left: 2rem;
}
</style>
