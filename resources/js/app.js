require("./bootstrap");
window.Vue = require("vue");

import Axios from "axios";


//axios config
Axios.defaults.headers.common = {
    Authorization: `Bearer ${localStorage.getItem("admin_token")}`,
    "Access-Control-Allow-Origin": "*",
    "Content-Type": "application/json",
    Accept: "application/json"
};
Axios.defaults.baseURL = "https://eshop.test/api/admin/";
Vue.prototype.$http = Axios;
//axios config

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);


import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);



Vue.component("login", require("./views/Login.vue").default);
Vue.component("sidebar", require("./components/SideBar.vue").default);
Vue.component("navbar", require("./components/NavBar.vue").default);

import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Dashboard.vue").default
    },
    {
        path: "/login",
        name: "Login",
        meta: {
            requiresAuth: false
        },
        component: require("./views/Login.vue").default
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Dashboard.vue").default
    },
    {
        path: "/customers",
        name: "Customers",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Customers.vue").default
    },
    {
        path: "/transactions",
        name: "Transactions",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Transactions.vue").default
    },
    {
        path: "/transaction/detail/:transaction_id",
        name: "TransactionsDetail",
        meta: {
            requiresAuth: true
        },
        component: require("./views/TransactionDetail.vue").default
    },

    {
        path: "/books",
        name: "Books",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Books.vue").default
    },

    {
        path: "/sliders",
        name: "Sliders",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Sliders.vue").default
    },
    {
        path: "/categories",
        name: "Categories",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Categories.vue").default
    },
    {
        path: "/units",
        name: "Units",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Units.vue").default
    },

    {
        path: "/settings",
        name: "Settings",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Settings.vue").default
    },

    {
        path: "/logout",
        name: "Logout",
        meta: {
            requiresAuth: true
        },
        component: require("./views/Logout.vue").default
    }
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    if (localStorage.getItem("admin_token")) {
        if (to.matched.some(record => record.meta.requiresAuth)) {
            next();
            return;
        } else {
            if (to.name == "Login") {
                next("/");
                return;
            } else {
                next();
                return;
            }
        }
    } else {
        if (to.matched.some(record => record.meta.requiresAuth)) {
            next("/login");
            return;
        }
        next();
        return;
    }
});

const app = new Vue({
    el: "#app",
    router
});
