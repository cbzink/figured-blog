window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
}

import Vue from "vue";

Vue.use(require("vue-moment"));

import Notifications from "vue-notification";
Vue.use(Notifications);

import router from "./router";
import store from "./store";

import App from "./views/App";

const app = new Vue({
    el: "#app",
    router,
    store,
    render: h => h(App)
});
