<template>
    <div class="wrapper">
        <div class="main">
            <router-view />
        </div>
    </div>
</template>

<script>
    import Sidebar from "../../components/backend/app/Sidebar";
    import Navbar from "../../components/backend/app/Navbar";
    import Footer from "../../components/backend/app/Footer";

    export default {
        components: { Navbar, Sidebar, Footer },
    }
</script>

<style lang="scss" src="@scss/backend/main.scss" />
