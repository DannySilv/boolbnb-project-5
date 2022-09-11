<template>
    <div v-if="!loading">
        <div class="ms-container">
            <h2 class="text-center pt-5">
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
                    <!-- Card -->
                    <div class="card mb-3" style="height: 470px">
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
                                class="gradient-button gradient-button-1"
                                >Scopri di più</router-link
                            >
                        </div>
                    </div>
                    <!-- Card -->
                </div>
            </div>
            <div v-else class="row row-cols-3">
                <div
                    v-for="accomodation in accomodations"
                    :key="accomodation.id"
                    class="col"
                >
                    <!-- Card -->
                    <div class="card mb-3" style="height: 470px">
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
                                class="gradient-button gradient-button-1"
                                >Scopri di più</router-link
                            >
                        </div>
                    </div>
                    <!-- Card -->
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <Loader />
    </div>
</template>

<script>
import SearchBar from "../components/SearchBar.vue";
import Loader from "../components/Loader.vue";

export default {
    name: "Home",
    components: {
        SearchBar,
        Loader,
    },
    data() {
        return {
            accomodations: [],
            filteredAccomodations: [],
            searchKey: "",
            loading: true,
        };
    },
    created() {
        this.getAccomodations();
    },
    computed: {
        homeAccomodations() {
            this.loading = true;
            let newAccomodations = [];
            if (this.filteredAccomodations.length != 0) {
                this.filteredAccomodations.forEach((accomodation) => {
                    newAccomodations.push(accomodation);
                });
            }
            this.loading = false;
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
        loadingScreen(boolean) {
            this.loading = boolean;
        },
        getAccomodations() {
            axios
                .get("http://127.0.0.1:8000/api/accomodations")
                .then((resp) => {
                    this.accomodations = resp.data.appResults;
                    this.loading = false;
                });
        },
    },
};
</script>

<style lang="scss" scoped>
// @import "../style/style.scss";

h1 {
    color: white;
    font-size: 4.5rem;
    margin-top: calc(25% - 50px);
    margin-left: 2rem;
}

.gradient-button {
    margin: 10px;
    font-size: 1em;
    padding: 5px 20px 5px 20px;
    text-align: center;
    text-transform: uppercase;
    transition: 1s;
    background-size: 200% auto;
    color: white;
    border-radius: 5px;
    // width: 200px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    display: inline-block;
    border-radius: 5px;
}

.gradient-button-1 {
    background-image: linear-gradient(
        to right,
        #ff385c 0%,
        #ff385daf 51%,
        #ff385c 100%
    );
}
.gradient-button-1:hover {
    background-position: right center;
    text-decoration: none;
}

img {
    width: 100%;
    height: 280px;
}
</style>
