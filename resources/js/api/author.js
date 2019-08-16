import { APP_CONFIG } from "../config.js";

export default {
    getMe: function() {
        return axios.get(APP_CONFIG.API_URL + "/author/me");
    }
};
