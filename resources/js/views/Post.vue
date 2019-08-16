<template>
    <div>
        <loading :active.sync="isLoading" :is-full-page="true"></loading>
        <single-post :post="post"></single-post>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";

import PostAPI from "../api/post";
import SinglePost from "./SinglePost";

export default {
    name: "post",

    props: ["id"],

    components: { SinglePost, Loading },

    data() {
        return {
            post: {},
            isLoading: false
        };
    },

    mounted() {
        this.isLoading = true;

        PostAPI.getPost(this.id)
            .then(response => {
                this.post = response.data.data;
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
};
</script>