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
                        <button
                            v-if="$route.name == 'accomodations'"
                            class="btn abs-2"
                            data-toggle="collapse"
                            data-target="#collapseFilter"
                            aria-expanded="false"
                            aria-controls="collapseFilter"
                        >
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div> 
                <router-link
                    v-if="$route.name == 'home'"
                    :to="{ name:'accomodations' }"
                    class="align-self-center">
                    <button class="btn ms-login ml-2">Ricerca Avanzata</button>
                </router-link> 
            </div>
        </div>
        <div class="collapse mt-3" id="collapseFilter">
        <div class="d-flex align-items-center">
            <h6>Inserisci il numero di camere desiderato:</h6>
            <select v-model="selectedRooms">
                <option selected>{{ selectedRooms }}</option>
                <option
                    :value="room"
                    v-for="(room, index) in rooms"
                    :key="index"
                >
                    {{ room }}
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center mt-2">
            <h6>Inserisci il numero di letti desiderato:</h6>
            <select v-model="selectedBeds">
                <option selected>{{ selectedBeds }}</option>
                <option
                    :value="bed"
                    v-for="(bed, index) in beds"
                    :key="index"
                >
                    {{ bed }}
                </option>
            </select>
        </div>
        <div class="d-flex align-items-center my-2">
            <h6>Inserisci il raggio di ricerca:</h6>
            <span>{{ distance }} Km</span>
            <input
                class="mx-3"
                type="range"
                min="5"
                max="100"
                name="distance"
                id="distance"
                v-model.number="distance"
            />
        </div>
        <label for="facilities">Inserisci i servizi desiderati:</label>
        <div class="d-flex flex-wrap mb-3">
            <div
                class="form-check mr-3"
                v-for="facility in facilities"
                :key="facility.id"
            >
                <input
                    name="facilities"
                    class="form-check-input"
                    type="checkbox"
                    :value="facility.id"
                    :id="facility.name"
                    v-model="selectedFacilities"
                />
                <label :for="facility.name" class="form-check-label">
                    {{ facility.name }}
                </label>
            </div>
        </div>
        </div>         
    </div>
</template>

<script>
export default {
    name: "SearchBar",
    data() {
        return {
            searchedText: "",
            accomodations: [],
            facilities: [],
            beds: [],
            rooms: [],
            selectedBeds: 'Nessuna selezione',
            selectedRooms: 'Nessuna selezione',
            selectedFacilities: [],
            searchedAccomodations: [],
            startedSearch: false,
            noResults: false,
            loadingScreen: true,
            searchCoordinates: [],
            distance: 20,
        };
    },
    created() {
        this.getFacilitiesAndServices();
    },
    methods: {
        sendSearch() {
            this.searchedApps = [];
            if (this.searchedText != '') {
                this.search();
            }
        },      
        resetClick() {
            this.searchedText = "";
            this.startedSearch = false;
            this.searchedAccomodations = [];
            this.selectedBeds = 'Nessuna selezione';
            this.selectedRooms = 'Nessuna selezione';
            this.selectedFacilities = [];
            this.distance = 20;
            this.noResults = false;
            this.$emit('noResults', this.noResults);
            this.$emit('startedSearch', this.startedSearch);
            this.$emit('searchedAccomodations', this.searchedAccomodations);
        },
        search() {
            axios.post("http://127.0.0.1:8000/api/coordinates/", {
                params: {
                    query: this.searchedText,
                }
            }).then(resp=> {
                this.$emit('searchedText', this.searchedText);
                this.searchCoordinates = resp.data.results;
                if (this.$route.name == 'home') {
                    this.getHomeAccomodations();
                } else if (this.$route.name == 'accomodations') {
                    this.getFilteredAccomodations();
                }
            });
        },
        getHomeAccomodations() {
            axios.get(('http://127.0.0.1:8000/api/accomodations'))
                .then((resp) => {
                    axios.post('http://127.0.0.1:8000/api/distance', {
                        params: {
                            accomodations: resp.data.appResults,
                            coordinates: this.searchCoordinates,
                            distance: this.distance
                        }
                    }).then((resp) => {
                        this.searchedAccomodations = resp.data.results;
                        if (this.searchedAccomodations.length == 0) {
                            this.searchedAccomodations = [];
                            this.startedSearch = false;
                            this.$emit('startedSearch', this.startedSearch);
                            this.noResults = true;
                            this.$emit('noResults', this.noResults);
                            this.$emit('searchedAccomodations',this.searchedAccomodations);
                        }
                        this.startedSearch = true;
                        this.$emit('startedSearch', this.startedSearch);
                        this.noResults = false;
                        this.$emit('noResults', this.noResults);
                        this.$emit('searchedAccomodations',this.searchedAccomodations);                       
                    })
            })
        },
        getFilteredAccomodations() {
            axios.get(('http://127.0.0.1:8000/api/accomodations'))
                .then((resp) => {
                    axios.post('http://127.0.0.1:8000/api/filteredDistance', {
                        params: {
                            accomodations: resp.data.appResults,
                            coordinates: this.searchCoordinates,
                            distance: this.distance,
                            selectedBeds: this.selectedBeds,
                            selectedRooms: this.selectedRooms,
                            selectedFacilities: this.selectedFacilities
                        }
                    }).then((resp) => {
                        this.searchedAccomodations = resp.data.results;
                        if (this.searchedAccomodations.length == 0) {
                            this.searchedAccomodations = [];
                            this.startedSearch = false;
                            this.$emit('startedSearch', this.startedSearch);
                            this.noResults = true;
                            this.$emit('noResults', this.noResults);
                            this.$emit('searchedAccomodations',this.searchedAccomodations);
                        }
                        this.startedSearch = true;
                        this.$emit('startedSearch', this.startedSearch);
                        this.noResults = false;
                        this.$emit('noResults', this.noResults);
                        this.$emit('searchedAccomodations',this.searchedAccomodations);
                    })
            })
        },
        getFacilitiesAndServices() {
            axios.get("http://127.0.0.1:8000/api/accomodations").then((resp) => {
                this.accomodations = resp.data.appResults;
                this.facilities = resp.data.facResults;
                this.accomodations.forEach((accomodation) => {
                    let n_rooms = parseInt(accomodation.n_rooms);
                    if (!this.rooms.includes(n_rooms)) {
                        this.rooms.push(n_rooms);
                        this.rooms.sort(function (a, b) {
                            return a - b;
                        });
                    }
                });
                this.accomodations.forEach((accomodation) => {
                    let n_beds = parseInt(accomodation.n_beds);
                    if (!this.beds.includes(n_beds)) {
                        this.beds.push(n_beds);
                        this.beds.sort(function (a, b) {
                            return a - b;
                        });
                    }
                });
            });
        },
    }                
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
    top: 0;
    right: 0;
}

.ms-login {
    color: white;
    border-color: #ff385c;
    background-color: #ff385c;
}

.btn:active {
    box-shadow: none !important;
}

.btn:focus {
    outline: 0;
    box-shadow: none !important;
    color: #ff385c;
}
</style>
