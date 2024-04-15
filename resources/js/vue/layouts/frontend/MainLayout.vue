<template>
    <div class="wrapper">
        <navbar />
        <router-view />
        <app-footer />
    </div>
</template>

<script>
    import Navbar from "@vue/components/frontend/app/Navbar.vue"
    import AppFooter from "@vue/components/frontend/app/Footer.vue"

    export default {
        components: { Navbar, AppFooter },
    }
</script>

<style lang="scss" src="@scss/frontend/main.scss" />
