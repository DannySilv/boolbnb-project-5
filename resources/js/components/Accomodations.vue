<template>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="searchbar position-relative">
                <input
                    class="search"
                    type="text"
                    placeholder="Cerca una città o un indirizzo"
                    v-model="searchKey"
                    @keyup.enter="sendSearch()"
                />
                <div class="d-flex justify-content-between my_btns">
                    <button class="btn abs-1" @click="sendSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn abs-2" @click="resetClick()">
                        <i class="fas fa-redo"></i>
                    </button>
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
            </div>
        </div>
        <div class="collapse" id="collapseFilter">
            <div class="d-flex align-items-center">
                <h6>Inserisci il numero di camere desiderato:</h6>
                <select v-model="selectedRooms">
                    <option value="" disabled selected hidden></option>
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
                    <option value="" disabled selected hidden></option>
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
                    min="20"
                    max="100"
                    name="radius"
                    id="radius"
                    v-model="distance"
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
                    />
                    <label :for="facility.name" class="form-check-label">
                        {{ facility.name }}
                    </label>
                </div>
            </div>
        </div>
        <div v-if="startSearch" class="row row-cols-3">
            <div
                v-for="accomodation in accomodations"
                :key="accomodation.id"
                class="col"
            >
                <Card :accomodation="accomodation" />
            </div>
        </div>
        <div v-else class="row row-cols-3">
            <div
                v-for="accomodation in filteredAccomodations"
                :key="accomodation.id"
                class="col"
            >
                <Card :accomodation="accomodation" />
            </div>
        </div>
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
import Card from "../components/Card.vue";
export default {
    name: "Accomodations",
    components: {
        Card,
    },
    data() {
        return {
            accomodations: [],
            facilities: [],
            beds: [],
            rooms: [],
            filteredAccomodations: [],
            searchKey: "",
            startSearch: true,
            distance: 20,
            selectedBeds: null,
            selectedRooms: null,
            selectedFacilities: [],
        };
    },
    created() {
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
    methods: {
        sendSearch() {
            let searchWord = this.searchKey;
            this.filteredAccomodations = [];
            let filteredAccomodations = this.filteredAccomodations;
            this.accomodations.forEach((accomodation) => {
                if (
                    accomodation.address
                        .toLowerCase()
                        .includes(searchWord.toLowerCase())
                ) {
                    filteredAccomodations.push(accomodation);
                }
            });
            this.filteredAccomodations = filteredAccomodations;
            this.startSearch = false;
            this.searchKey = "";
        },
        resetClick() {
            this.searchKey = "";
            this.filteredAccomodations = [];
            this.startSearch = true;
        },
    },
};
</script>

<style lang="scss" scoped>
.searchbar {
    margin-top: 80px;
    margin-bottom: 1rem;
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
