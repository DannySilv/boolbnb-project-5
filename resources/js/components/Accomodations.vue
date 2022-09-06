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
                    name="radius"
                    id="radius"
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
            noRes: false,
            distance: 20,
            selectedBeds: "Nessuna selezione",
            selectedRooms: "Nessuna selezione",
            selectedFacilities: [],
            searchCoordinates: [],
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
            this.getSearchPosition();
            setTimeout(() => {
                // No filters
                if (
                    this.selectedBeds == "Nessuna selezione" &&
                    this.selectedRooms == "Nessuna selezione" &&
                    this.selectedFacilities.length == 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        if (searchDistance <= this.distance) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Beds
                else if (
                    this.selectedBeds != "Nessuna selezione" &&
                    this.selectedRooms == "Nessuna selezione" &&
                    this.selectedFacilities.length == 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedBeds = this.selectedBeds;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        if (
                            accomodation.n_beds == selectedBeds &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedBeds = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Rooms
                else if (
                    this.selectedBeds == "Nessuna selezione" &&
                    this.selectedRooms != "Nessuna selezione" &&
                    this.selectedFacilities.length == 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedRooms = this.selectedRooms;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        if (
                            accomodation.n_rooms == selectedRooms &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedRooms = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Facilities
                else if (
                    this.selectedBeds == "Nessuna selezione" &&
                    this.selectedRooms == "Nessuna selezione" &&
                    this.selectedFacilities.length != 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedFacilities = this.selectedFacilities;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        let singleFacilityId = [];
                        let selectedFacilitiesIds = [];
                        let comparativeArray = [];
                        accomodation.facilities.forEach((facility) => {
                            singleFacilityId.push(facility.id);
                        });
                        selectedFacilities.forEach((id) => {
                            selectedFacilitiesIds.push(id);
                        });
                        selectedFacilitiesIds.forEach((id) => {
                            comparativeArray.push(
                                singleFacilityId.includes(id)
                            );
                        });
                        if (
                            !comparativeArray.includes(false) &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Beds + Rooms
                else if (
                    this.selectedBeds != "Nessuna selezione" &&
                    this.selectedRooms != "Nessuna selezione" &&
                    this.selectedFacilities.length == 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedBeds = this.selectedBeds;
                    let selectedRooms = this.selectedRooms;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        if (
                            accomodation.n_beds == selectedBeds &&
                            accomodation.n_rooms == selectedRooms &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedBeds = "Nessuna selezione";
                    this.selectedRooms = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Beds + Rooms + Facilities
                else if (
                    this.selectedBeds != "Nessuna selezione" &&
                    this.selectedRooms != "Nessuna selezione" &&
                    this.selectedFacilities.length != 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedBeds = this.selectedBeds;
                    let selectedRooms = this.selectedRooms;
                    let selectedFacilities = this.selectedFacilities;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        let singleFacilityId = [];
                        let selectedFacilitiesIds = [];
                        let comparativeArray = [];
                        accomodation.facilities.forEach((facility) => {
                            singleFacilityId.push(facility.id);
                        });
                        selectedFacilities.forEach((id) => {
                            selectedFacilitiesIds.push(id);
                        });
                        selectedFacilitiesIds.forEach((id) => {
                            comparativeArray.push(
                                singleFacilityId.includes(id)
                            );
                        });
                        if (
                            accomodation.n_beds == selectedBeds &&
                            accomodation.n_rooms == selectedRooms &&
                            !comparativeArray.includes(false) &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedBeds = "Nessuna selezione";
                    this.selectedRooms = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Beds + Facilities
                else if (
                    this.selectedBeds != "Nessuna selezione" &&
                    this.selectedRooms == "Nessuna selezione" &&
                    this.selectedFacilities.length != 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedBeds = this.selectedBeds;
                    let selectedFacilities = this.selectedFacilities;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        let singleFacilityId = [];
                        let selectedFacilitiesIds = [];
                        let comparativeArray = [];
                        accomodation.facilities.forEach((facility) => {
                            singleFacilityId.push(facility.id);
                        });
                        selectedFacilities.forEach((id) => {
                            selectedFacilitiesIds.push(id);
                        });
                        selectedFacilitiesIds.forEach((id) => {
                            comparativeArray.push(
                                singleFacilityId.includes(id)
                            );
                        });
                        if (
                            accomodation.n_beds == selectedBeds &&
                            !comparativeArray.includes(false) &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedBeds = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
                // Rooms + Facilities
                else if (
                    this.selectedBeds == "Nessuna selezione" &&
                    this.selectedRooms != "Nessuna selezione" &&
                    this.selectedFacilities.length != 0 &&
                    this.searchKey != ""
                ) {
                    let searchLat = this.searchCoordinates[0].latitude;
                    let searchLon = this.searchCoordinates[0].longitude;
                    let selectedRooms = this.selectedRooms;
                    let selectedFacilities = this.selectedFacilities;
                    this.filteredAccomodations = [];
                    let filteredAccomodations = this.filteredAccomodations;
                    this.accomodations.forEach((accomodation) => {
                        let searchDistance = this.getDistanceFromLatLonInKm(
                            accomodation.latitude,
                            accomodation.longitude,
                            searchLat,
                            searchLon
                        );
                        let singleFacilityId = [];
                        let selectedFacilitiesIds = [];
                        let comparativeArray = [];
                        accomodation.facilities.forEach((facility) => {
                            singleFacilityId.push(facility.id);
                        });
                        selectedFacilities.forEach((id) => {
                            selectedFacilitiesIds.push(id);
                        });
                        selectedFacilitiesIds.forEach((id) => {
                            comparativeArray.push(
                                singleFacilityId.includes(id)
                            );
                        });
                        if (
                            accomodation.n_rooms == selectedRooms &&
                            !comparativeArray.includes(false) &&
                            searchDistance <= this.distance
                        ) {
                            filteredAccomodations.push(accomodation);
                        }
                    });
                    this.filteredAccomodations = filteredAccomodations;
                    if (filteredAccomodations.length == 0) {
                        this.noRes = true;
                    } else {
                        this.noRes = false;
                    }
                    this.selectedRooms = "Nessuna selezione";
                    this.startSearch = false;
                    this.searchCoordinates = [];
                }
            }, 1500);
        },
        resetClick() {
            this.searchKey = "";
            this.selectedFacilities = [];
            this.selectedBeds = "Nessuna selezione";
            this.selectedRooms = "Nessuna selezione";
            this.distance = 20;
            this.searchCoordinates = [];
            this.filteredAccomodations = [];
            this.startSearch = true;
        },
        getSearchPosition() {
            axios
                .post("http://127.0.0.1:8000/api/distance/", {
                    params: {
                        query: this.searchKey,
                    },
                })
                .then((resp) => {
                    this.searchCoordinates = resp.data.results;
                });
        },
        getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the earth in km
            let dLat = this.deg2rad(lat2 - lat1); // deg2rad below
            let dLon = this.deg2rad(lon2 - lon1);
            let a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(this.deg2rad(lat1)) *
                    Math.cos(this.deg2rad(lat2)) *
                    Math.sin(dLon / 2) *
                    Math.sin(dLon / 2);
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            let d = R * c; // Distance in km
            return d;
        },

        deg2rad(deg) {
            return deg * (Math.PI / 180);
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
    color: #de2547;
}
</style>
