import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./views/Home";
import Compose from "./views/Compose";
import Post from "./views/Post";
import EditPost from "./views/EditPost";

import store from "./store";

Vue.use(VueRouter);

let router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/post/:id",
            name: "post",
            component: Post,
            props: true
        },
        {
            path: "/compose",
            name: "compose",
            component: Compose,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/post/:id/edit",
            name: "edit-post",
            component: EditPost,
            props: true,
            meta: {
                requiresAuth: true
            }
        }
    ]
});

router.beforeEach((to, from, next) => {
    function proceed() {
        if (to.matched.some(record => record.meta.requiresAuth)) {
            if (store.getters["authors/getIsLoggedIn"] !== true) {
                window.location.href = "/login";
                next(false);
            } else {
                next();
            }
        } else {
            next();
        }
    }

    if (store.getters["authors/getMeLoadStatus"] == 0) {
        store.dispatch("authors/loadMe");

        store.watch(() => store.getters["authors/getMeLoadStatus"], () => {
            proceed();
        });
    } else {
        proceed();
    }
});

export default router;
