<template>
    <div class="wrapper">
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

    export default {
        components: { Navbar, Sidebar, AppFooter },
    }
</script>

<style lang="scss" src="@scss/backend/main.scss" />
