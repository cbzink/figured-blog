<template>
    <div class="container mx-auto my-8 px-2 md:px-16">
        <notifications />
        <header class="mb-8 text-center">
            <router-link to="/">
                <h1 class="text-4xl font-bold text-blue-800">Figured <span class="font-normal text-gray-800">Blog</span></h1>
            </router-link>

            <div class="flex justify-center">
                <a href="/login" class=" text-xs font-semibold text-blue-800 hover:underline" v-if="!isLoggedIn">Author Login</a>
            
                <router-link to="/compose" class="text-xs font-semibold text-blue-800 mr-3 hover:underline" v-if="isLoggedIn">Compose</router-link>
                <a href="/logout" class=" text-xs font-semibold text-blue-800 hover:underline" v-if="isLoggedIn">Logout</a>
            </div>
        </header>

        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "app",

    computed: {
        isLoggedIn() {
            return this.$store.getters["authors/getIsLoggedIn"];
        }
    }
};
</script>