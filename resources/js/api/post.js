import { APP_CONFIG } from "../config.js";

export default {
    getAll: function() {
        return axios.get(APP_CONFIG.API_URL + "/post");
    },

    getPost: function(id) {
        return axios.get(APP_CONFIG.API_URL + "/post/" + id);
    },

    storePost: function(post) {
        return axios.post(APP_CONFIG.API_URL + "/post", post);
    },

    updatePost: function(id, post) {
        return axios.put(APP_CONFIG.API_URL + "/post/" + id, post);
    },

    deletePost: function(id) {
        return axios.delete(APP_CONFIG.API_URL + "/post/" + id);
    }
};
