import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from "./pages/Home.vue";
import Blog from "./pages/Blog.vue";
import Accomodation from "./pages/Accomodation.vue";

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/blog",
      name: "blog",
      component: Blog
    },
    {
      path: "/blog/:slug",
      name: "accomodation",
      component: Accomodation
    },
  ]
});

export default router;