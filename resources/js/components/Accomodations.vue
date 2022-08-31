<template>
    <div class="container">
        <h1 class="text-center my-5 pt-5">Accomodations List</h1>
        <div class="row row-cols-3">
            <div
                v-for="accomodation in accomodations"
                :key="accomodation.id"
                class="col"
            >
                <Card :accomodation="accomodation" />
            </div>
        </div>
        <nav aria-label="..." class="d-flex justify-content-center">
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
        </nav>
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
            currentPage: 1,
            lastPage: 0,
        };
    },
    created() {
        this.getAccomodations(1);
    },
    methods: {
        getAccomodations(pages) {
            axios
                .get("http://127.0.0.1:8000/api/accomodations", {
                    params: {
                        page: pages,
                    },
                })
                .then((resp) => {
                    this.accomodations = resp.data.results.data;
                    this.currentPage = resp.data.results.current_page;
                    this.lastPage = resp.data.results.last_page;
                });
        },
    },
};
</script>
