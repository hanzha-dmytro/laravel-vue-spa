<template>
    <nav id="sidebar" :class="['sidebar', { collapsed: collapsed }]">
        <div class="sidebar-content">
            <router-link :to="{ name: 'admin.dashboard' }" class="sidebar-logo">
                <div class="image-block"></div>
                <span class="align-middle">Vuester</span>
            </router-link>
            <ul class="sidebar-nav">
                <router-link exact :to="{ name: 'admin.dashboard' }" v-slot="{ href, route, navigate, isActive }" custom>
                    <li class="sidebar-item" :class="[isActive && 'active']">
                        <a class="sidebar-link" :href="href" @click="navigate">
                            <i class="fa-solid fa-tachometer-alt align-middle"></i>
                            <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                </router-link>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        computed: {
            collapsed() {
                return this.$store.getters["sidebar/collapsed"];
            }
        },
    }
</script>

