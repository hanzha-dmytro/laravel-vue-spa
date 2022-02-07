<template>
    <app-loader v-if="!loaded" />
    <router-view v-else />
</template>

<script>
    import AppLoader from './components/backend/app/AppLoader'

    export default {
        computed: {
            loaded() {
                return this.$store.getters["loaded"];
            }
        },
        components: { AppLoader },
    }
</script>

<style lang="scss">
    #app {
        display: flex;
        align-items: stretch;
        height: 100vh;
    }
</style>
