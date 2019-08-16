<template>
    <div class="bg-white rounded shadow-lg p-8 mb-6">
        <loading :active.sync="isLoading" :is-full-page="true"></loading>
        <div class="flex justify-between items-center">
            <router-link :to="{ name: 'post', params: { id: post.id } }">
                <h2 class="text-xl font-semibold border-b border-dashed border-gray-300 hover:border-gray-500">{{ post.title }}</h2>
            </router-link>

            <div v-if="isLoggedIn" class="flex">
                <router-link :to="{ name: 'edit-post', params: { id: post.id } }">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current text-gray-300 hover:text-gray-500"><path class="heroicon-ui" d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg>
                </router-link>
                
                <button class="ml-2" @click="deletePost">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="fill-current text-gray-300 hover:text-gray-500"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg>
                </button>
            </div>
        </div>

        <vue-markdown class="mt-8 text-lg post-body">{{ post.body }}</vue-markdown>

        <div class="mt-8 flex flex-wrap tags">
            <div class="m-1 px-2 py-2 bg-gray-200 text-xs" v-for="tag in post.tags">{{ tag }}</div>
        </div>

        <div class="mt-2 text-xs text-gray-500 uppercase font-bold">Posted by {{ post.author.name }} on {{ post.created_at | moment("dddd, MMMM Do YYYY") }}</div></div>
    </div>
</template>

<script>
import VueMarkdown from "vue-markdown";
import Loading from "vue-loading-overlay";

import PostAPI from "../api/post";

export default {
    name: "single-post",

    components: { VueMarkdown, Loading },

    props: ["post"],

    data() {
        return {
            isLoading: false
        };
    },

    computed: {
        isLoggedIn() {
            return this.$store.getters["authors/getIsLoggedIn"];
        }
    },

    methods: {
        deletePost() {
            this.isLoading = true;

            PostAPI.deletePost(this.post.id)
                .then(response => {
                    window.location.href = "/";
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
    }
};
</script>

<style>
/* For some reason Tailwind's "first" pseudo-class variant wasn't working. */
.tags div:first-child {
    margin-left: 0px;
}

.post-body p {
    margin-top: 1rem;
    margin-bottom: 1rem;
}
</style>