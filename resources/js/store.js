import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import { authors } from "./modules/authors.js";

export default new Vuex.Store({
    modules: {
        authors
    }
});
