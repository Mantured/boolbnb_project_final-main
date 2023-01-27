window.axios = require("axios");
delete axios.defaults.headers.common["X-CSRF-TOKEN"];
delete axios.defaults.headers.common["X-Requested-With"];

window.Vue = require("vue");

import App from "./views/App.vue";

// Importo bootstrap js
import "bootstrap/dist/js/bootstrap.min.js";
/* import "sweetalert2/src/sweetalert2.scss"; */
// § Importo e utilizzo VueRouter
import VueRouter from "vue-router";
window.Vue.use(VueRouter);

// § Importo e utilizzo VueSweetalert2 per i messaggi di popup
import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
import "sweetalert2/dist/sweetalert2.min.css";

// ? Importo tutte le pagine del front-office che andrò a gestire con le rotte vue
// import PostList from "./pages/PostList.vue";
import Home from "./pages/Home.vue";
import NotFound from "./pages/NotFound.vue";
import About from "./pages/About.vue";
import ApartmentList from "./pages/ApartmentList.vue";
import Show from "./pages/Show.vue";

// ? Costruisco tutte le rotte necessarie
const router = new VueRouter({
    // mode history serve ad aggiornare il link nella barra degli indirizzi al cambio della rotta
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/about-us",
            name: "about-us",
            component: About,
        },
        /* I nomi di queste rotte sono da cambiare */
        {
            path: "/apartment",
            name: "apartment",
            component: ApartmentList,
            props: true,
        },
        /* {
            path: "/apt/:id",
            name: "apt",
            component: Show,
        }, */
        {
            path: "/apartment/:id",
            name: "apartment-show",
            component: Show,
        },
        {
            path: "*",
            name: "not-found",
            component: NotFound,
        },
    ],
});

const app = new Vue({
    el: "#root",
    router, // Utilizzo le rotte appena create
    render: (h) => h(App),
});
