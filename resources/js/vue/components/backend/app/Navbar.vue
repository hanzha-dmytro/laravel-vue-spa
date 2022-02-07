<template>
    <nav class="navbar navbar-expand navbar-light navbar-bg">
        <a class="sidebar-toggle js-sidebar-toggle" @click.prevent="toggle">
            <i class="fa-solid fa-bars align-self-center"></i>
        </a>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
                <li class="nav-item dropdown user-menu">
                    <div class="nav-icon d-inline-block d-sm-none" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-cog"></i>
                    </div>
                    <div class="user-block nav-link dropdown-toggle d-none d-sm-flex" data-bs-toggle="dropdown">
                        <img :src="user.avatar || images.avatar" class="img-fluid rounded" :alt="user.name" />
                        <div class="user-info">
                            <span class="user-name">{{ user.name }}</span>
                            <span class="user-role" v-if="user.role">{{ user.role.name }}</span>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-user align-middle me-2"></i>
                            <span class="align-middle">Profile</span>
                        </a>

                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-cogs align-middle mr-1"></i>
                            <span class="align-middle">Settings</span>
                        </a>

                        <a href="#" class="dropdown-item">
                            <i class="fa-solid fa-globe align-middle mr-1"></i>
                            <span class="align-middle">Go to site</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <button class="dropdown-item" @click.prevent="logout">
                            <i class="fa-solid fa-sign-out-alt align-middle mr-1"></i>
                            <span class="align-middle">Log out</span>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

</template>

<script>
import avatar from '../../../../../images/backend/user-default-image.jpg'

export default {
    data () {
        return {
            images: { avatar },
            timeout: null,
        }
    },
    computed: {
        user() {
            return this.$store.getters["auth/user"];
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('auth/logout')
                .then(() => {
                    this.$router.push({ name: 'admin.auth.login' })
                })
        },
        toggle() {
            this.$store.dispatch('sidebar/toggle')
        }
    }
}
</script>
