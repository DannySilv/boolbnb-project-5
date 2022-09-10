<template>
    <div class="searchbar">
        <div class="d-flex justify-content-center mt-3">
            <div class="d-flex justify-content-center">
                <div class="position-relative">
                    <input
                        class="search"
                        type="text"
                        placeholder="Cerca una città o un indirizzo"
                        v-model="searchedText"
                    />
                    <div class="d-flex justify-content-between my_btns">
                        <button class="btn abs-1" @click="sendSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn abs-2" @click="resetClick()">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
                <router-link
                    v-if="$route.name == 'home'"
                    :to="{ name: 'accomodations' }"
                    class="align-self-center"
                >
                    <button class="btn ms-login ml-2">Ricerca Avanzata</button>
                </router-link>
            </div>
        </div>
    </div>
    <!-- <div v-if="sponsoredAccomodation.length != 0" class="row row-cols-3">
            <div
                v-for="accomodation in sponsoredAccomodations"
                :text="accomodation.id"
                class="col"
            >
                <Card :accomodation="accomodation" />
            </div>
        </div> -->
</template>

<script>
export default {
    name: "SearchBar",
    props: {
        newDistance: Number,
        selectedBeds: Number,
        selectedRooms: Number,
        selectedFacilities: Array,
    },
    data() {
        return {
            searchedText: "",
            searchedAccomodations: [],
            startedSearch: false,
            noResults: false,
            searchCoordinates: [],
            distance: 20,
        };
    },
    methods: {
        sendSearch() {
            this.searchedApps = [];
            if (this.newDistance && this.distance != 0) {
                this.distance = this.newDistance;
            }
            if (this.searchedText != "") {
                this.search();
            }
        },
        resetClick() {
            this.searchedText = "";
            this.startedSearch = false;
            this.$emit("startedSearch", this.startedSearch);
        },
        search() {
            axios
                .post("http://127.0.0.1:8000/api/coordinates/", {
                    params: {
                        query: this.searchedText,
                    },
                })
                .then((resp) => {
                    this.$emit("searchedText", this.searchedText);
                    this.searchCoordinates = resp.data.results;
                    console.log(resp.data.results);
                    if (this.$route.name == "home") {
                        this.getHomeAccomodations();
                    } else if (this.$route.name == "accomodations") {
                        this.getFilteredAccomodations();
                    }
                });
        },
        getHomeAccomodations() {
            axios
                .get("http://127.0.0.1:8000/api/accomodations")
                .then((resp) => {
                    axios
                        .post("http://127.0.0.1:8000/api/distance", {
                            params: {
                                accomodations: resp.data.appResults,
                                coordinates: this.searchCoordinates,
                                distance: this.distance,
                            },
                        })
                        .then((resp) => {
                            this.searchedAccomodations = resp.data.results;
                            console.log(resp.data.results);
                            if (this.searchedAccomodations.length == 0) {
                                this.searchedAccomodations = [];
                                this.startedSearch = false;
                                this.noResults = true;
                                this.$emit("noResults", this.noResults);
                                this.$emit("startedSearch", this.startedSearch);
                                this.$emit(
                                    "searchedAccomodations",
                                    this.searchedAccomodations
                                );
                            }
                            this.startedSearch = true;
                            this.noResults = false;
                            this.$emit("noResults", this.noResults);
                            this.$emit("startedSearch", this.startedSearch);
                            this.$emit(
                                "searchedAccomodations",
                                this.searchedAccomodations
                            );
                        });
                });
        },
        getFilteredAccomodations() {
            axios
                .get("http://127.0.0.1:8000/api/accomodations")
                .then((resp) => {
                    axios
                        .post("http://127.0.0.1:8000/api/filteredDistance", {
                            params: {
                                accomodations: resp.data.appResults,
                                coordinates: this.searchCoordinates,
                                distance: this.distance,
                                selectedBeds: this.selectedBeds,
                                selectedRooms: this.selectedRooms,
                                selectedFacilities: this.selectedFacilities,
                            },
                        })
                        .then((resp) => {
                            this.searchedAccomodations = resp.data.results;
                            console.log(resp.data.results);
                            if (this.searchedAccomodations.length == 0) {
                                this.searchedAccomodations = [];
                                this.startedSearch = false;
                                this.noResults = true;
                                this.$emit("noResults", this.noResults);
                                this.$emit("startedSearch", this.startedSearch);
                                this.$emit(
                                    "searchedAccomodations",
                                    this.searchedAccomodations
                                );
                            }
                            this.startedSearch = true;
                            this.noResults = false;
                            this.$emit("noResults", this.noResults);
                            this.$emit("startedSearch", this.startedSearch);
                            this.$emit(
                                "searchedAccomodations",
                                this.searchedAccomodations
                            );
                        });
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.searchbar {
    margin: 0 10px;
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
    top: 6px;
    right: 0;
}

.ms-login {
    color: white;
    border-color: #ec2b00;
    background-color: #ec2b00;
}

.btn:active {
    box-shadow: none !important;
}

.btn:focus {
    outline: 0;
    box-shadow: none !important;
    color: black;
}
</style>
