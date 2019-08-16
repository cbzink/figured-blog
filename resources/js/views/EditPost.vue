<template>
    <div class="bg-white rounded shadow-lg p-8 mb-6">
        <loading :active.sync="isLoading" :is-full-page="true"></loading>
        <input type="text" v-model="title" placeholder="What will your post be called?" autofocus class="text-xl font-semibold border-b border-dashed border-gray-500 focus:outline-none w-full" :class="(errors['title']) ? 'border-red-500' : ''" />

        <textarea v-model="body" class="mt-8 text-lg focus:outline-none w-full" :class="(errors['body']) ? 'border border-dashed border-red-500' : ''" placeholder="Begin your masterpiece. PS: You can use Markdown here." rows="10"></textarea>

        <div class="mt-8 flex">
            <div class="w-1/2">
                <vue-tags-input
                    class="w-full"
                    :class="(errors['tags']) ? 'border border-dashed border-red-500' : ''"
                    placeholder="Add a few tags for your post"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
                />
            </div>

            <div class="w-1/2 text-right">
                <button @click="updatePost" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded">Update Post</button>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import VueTagsInput from "@johmun/vue-tags-input";

import PostAPI from "../api/post";

export default {
    name: "edit-post",

    components: { VueTagsInput, Loading },

    props: ["id"],

    data() {
        return {
            title: null,
            body: null,
            tags: [],
            errors: {},
            isLoading: false
        };
    },

    methods: {
        updatePost() {
            this.errors = {};
            this.isLoading = true;

            PostAPI.updatePost(this.id, {
                title: this.title,
                body: this.body,
                tags: this.tags.map(tag => {
                    return tag.text;
                })
            })
                .then(response => {
                    this.$router.push({
                        name: "post",
                        params: { id: response.data.data.id }
                    });
                    this.isLoading = false;
                })
                .catch(error => {
                    this.$notify({
                        title: "An error occurred.",
                        text: error.response.data.message,
                        type: "error"
                    });
                    this.errors = error.response.data.errors;
                    this.isLoading = false;
                });
        }
    },

    mounted() {
        this.isLoading = true;

        PostAPI.getPost(this.id)
            .then(response => {
                this.title = response.data.data.title;
                this.body = response.data.data.body;

                response.data.data.tags.forEach(tag => {
                    this.tags.push({ text: tag });
                });

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