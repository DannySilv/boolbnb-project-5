<template>
    <div class="container pt-60">
        <div
            class="container-fluid d-flex justify-content-center align-items-initial mb-5"
        >
            <SearchBar
                @searchedAccomodations="searchedAccomodations"
                @startedSearch="startedSearch"
                @noResults="noResults"
                :newDistance="distance"
                :selectedBeds="selectedBeds"
                :selectedRooms="selectedRooms"
                :selectedFacilities="selectedFacilities"
            />
            <button
                class="btn abs-2"
                data-toggle="collapse"
                data-target="#collapseFilter"
                aria-expanded="false"
                aria-controls="collapseFilter"
            >
                <i class="fas fa-filter"></i>
            </button>
        </div>
        <div class="collapse" id="collapseFilter">
            <div class="d-flex align-items-center">
                <h6>Inserisci il numero di camere desiderato:</h6>
                <select v-model="selectedRooms">
                    <option></option>
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
                    <option></option>
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
        <div v-if="startSearch" class="row row-cols-3">
            <div
                v-for="accomodation in filteredAccomodations"
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
        <h4 class="text-center" v-show="noRes">
            La tua ricerca non ha prodotto risultati.
        </h4>
        <!-- <nav aria-label="..." class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <a
                        @click="getAccomodations(currentPage - 1)"
                        class="page-link"
                        href="#"
                        tabindex="-1"
                        >Previous</a
                    >
                </li>
                <li
                    v-for="n in lastPage"
                    :key="n"
                    class="page-item"
                    :class="{ active: currentPage === n }"
                >
                    <a
                        @click="getAccomodations(n)"
                        class="page-link"
                        href="#"
                        >{{ n }}</a
                    >
                </li>
                <li
                    class="page-item"
                    :class="{ disabled: currentPage === lastPage }"
                >
                    <a
                        @click="getAccomodations(currentPage + 1)"
                        class="page-link"
                        href="#"
                        >Next</a
                    >
                </li>
            </ul>
        </nav> -->
    </div>
</template>

<script>
import SearchBar from "../components/SearchBar.vue";
export default {
    name: "Accomodations",
    components: {
        SearchBar,
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
        };
    },
    created() {
        this.getAccomodationsAndFacilities();
    },
    computed: {
        // searchAccomodations() {
        //     let searchAccomodations = [];
        //     if (this.filteredAccomodations.length != 0) {
        //         this.filteredAccomodations.forEach(accomodation => {
        //             searchAccomodations.push(accomodation);
        //         })
        //     }
        //     return searchAccomodations;
        // },
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
        getAccomodationsAndFacilities() {
            axios
                .get("http://127.0.0.1:8000/api/accomodations")
                .then((resp) => {
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
    top: 0;
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
</style>
