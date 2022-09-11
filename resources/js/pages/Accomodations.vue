<template>
    <div v-if="!loading">
        <div class="container pt-60">
            <div
                class="container-fluid d-flex justify-content-center align-items-end mb-5"
            >
                <SearchBar
                    @searchedAccomodations="searchedAccomodations"
                    @startedSearch="startedSearch"
                    @noResults="noResults"
                />
            </div>
            <div v-if="startSearch" class="row row-cols-3">
                <div
                    v-for="accomodation in filterAccomodations"
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
            <h4 class="text-center" v-show="noRes">
                La tua ricerca non ha prodotto risultati.
            </h4>
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
    name: "Accomodations",
    components: {
        SearchBar,
        Loader,
    },
    data() {
        return {
            accomodations: [],
            facilities: [],
            beds: [],
            rooms: [],
            selectedBeds: null,
            selectedRooms: null,
            selectedFacilities: [],
            filteredAccomodations: [],
            searchKey: "",
            startSearch: false,
            noRes: false,
            distance: 20,
            loading: true,
        };
    },
    created() {
        this.getAccomodations();
    },
    computed: {
        filterAccomodations() {
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
        startedSearch(boolean) {
            this.startSearch = boolean;
        },
        noResults(boolean) {
            this.noRes = boolean;
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
.pt-60 {
    padding-top: 60px;
}
.search {
    width: 500px;
    height: 35px;
    box-shadow: 1rem;
    border: 1px solid;
    border-radius: 40px;
    padding-left: 1rem;
    display: block;
    position: relative;
}
h6 {
    margin: 0;
    margin-right: 2rem;
    font-weight: 700;
}

.my_btns {
    position: absolute;
    top: 5px;
    right: 0;
}

.btn:active {
    box-shadow: none !important;
}

.btn:focus {
    outline: 0;
    box-shadow: none !important;
    color: red;
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
