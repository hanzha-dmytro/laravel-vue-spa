<template>
    <div class="wrapper">
        <toasts />
        <sidebar />
        <div class="main">
            <navbar />
            <router-view />
            <app-footer />
        </div>
    </div>
</template>

<script>
    import Sidebar from "../../components/backend/app/Sidebar";
    import Navbar from "../../components/backend/app/Navbar";
    import AppFooter from "../../components/backend/app/Footer";
    import Toasts from "../../components/backend/toast/Wrapper.vue";

    export default {
        components: { Navbar, Sidebar, AppFooter, Toasts },
    }
</script>

<style lang="scss" src="@scss/backend/main.scss" />
