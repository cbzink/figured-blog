<template>
    <div>
        <loading :active.sync="isLoading" :is-full-page="true"></loading>
        <single-post v-for="post in posts" v-bind:key="post.id" :post="post"></single-post>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";

import PostAPI from "../api/post.js";
import SinglePost from "./SinglePost";

export default {
    name: "home",

    components: { SinglePost, Loading },

    data() {
        return {
            posts: [],
            isLoading: false
        };
    },

    computed: {
        isLoggedIn() {
            return this.$store.getters["authors/getIsLoggedIn"];
        }
    },

    methods: {
        loadPosts() {
            this.isLoading = true;

            PostAPI.getAll()
                .then(response => {
                    this.posts = response.data.data;
                    this.isLoading = false;
                })
                .catch(error => {
                    this.$notify({
                        title: "An error occurred.",
                        text: error.response.data.message,
                        type: "error"
                    });
                    this.isLoading = false;
                });
        }
    },

    mounted() {
        this.loadPosts();
    }
};
</script>