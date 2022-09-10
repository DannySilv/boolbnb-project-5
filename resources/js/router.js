import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from "./pages/Home.vue";
import Accomodation from "./pages/Accomodation.vue";
import Accomodations from "./pages/Accomodations.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/:slug",
            name: "accomodation",
            component: Accomodation,
        },
        {
            path: "/accomodations/",
            name: "accomodations",
            component: Accomodations,
        },
    ],
});

export default router;
