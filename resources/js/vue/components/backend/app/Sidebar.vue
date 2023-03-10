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

                <hr>

                <router-link exact :to="{ name: 'admin.categories.index' }" v-slot="{ href, route, navigate, isActive }" v-if="$can('categories:read')" custom>
                    <li class="sidebar-item" :class="[isActive && 'active']">
                        <a class="sidebar-link" :href="href" @click="navigate">
                            <i class="fa-solid fa-rectangle-list align-middle"></i>
                            <span class="align-middle">Categories</span>
                        </a>
                    </li>
                </router-link>

                <hr>

                <router-link exact :to="{ name: 'admin.users.index' }" v-slot="{ href, route, navigate, isActive }" v-if="$can('users:read')" custom>
                    <li class="sidebar-item" :class="[isActive && 'active']">
                        <a class="sidebar-link" :href="href" @click="navigate">
                            <i class="fa-solid fa-users align-middle"></i>
                            <span class="align-middle">Users</span>
                        </a>
                    </li>
                </router-link>

                <router-link exact :to="{ name: 'admin.roles.index' }" v-slot="{ href, route, navigate, isActive }" v-if="$can('roles:read')" custom>
                    <li class="sidebar-item" :class="[isActive && 'active']">
                        <a class="sidebar-link" :href="href" @click="navigate">
                            <i class="fa-solid fa-user-tag align-middle"></i>
                            <span class="align-middle">Roles</span>
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

