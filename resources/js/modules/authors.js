import AuthorAPI from "../api/author.js";

export const authors = {
    namespaced: true,

    state: {
        me: {},
        meLoadStatus: 0,
        isLoggedIn: false
    },

    actions: {
        loadMe({ commit }) {
            return new Promise((resolve, reject) => {
                commit("setMeLoadStatus", 1);

                AuthorAPI.getMe().then(response => {
                    commit("setMe", response.data.data);
                    commit("setMeLoadStatus", 2);
                    commit("setIsLoggedIn", true);
                }).catch(error => {
                    commit("setMe", {});
                    commit("setMeLoadStatus", 3);
                    commit("setIsLoggedIn", false);
                });

                resolve();
            });
        }
    },

    mutations: {
        setMe(state, me) {
            state.me = me;
        },

        setMeLoadStatus(state, loadStatus) {
            state.meLoadStatus = loadStatus;
        },

        setIsLoggedIn(state, isLoggedIn) {
            state.isLoggedIn = isLoggedIn;
        }
    },

    getters: {
        getMe(state) {
            return state.me;
        },

        getMeLoadStatus(state) {
            return state.meLoadStatus;
        },

        getIsLoggedIn(state) {
            return state.isLoggedIn;
        }
    }
};
