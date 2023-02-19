<template>
    <main class="content">
        <div class="row mb-2">
            <div class="col-auto d-block">
                <h1 class="h4">Users</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <router-link :to="{ name: 'admin.users.create' }" :class="['btn btn-primary', { disabled: !$can('users:create') }]">New User</router-link>
            </div>
        </div>
        <div class="row flex-column flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData"/>
            <app-loader class="flex-fill" v-if="loading"/>
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!users.data.length">
                <span class="h2">There aren't users yet!</span>
            </div>
            <div class="col-12 users" v-else>
                <div class="row">
                    <list-item v-for="user in users.data" :user="user" :key="user.id" @removeUser="removeUser"/>
                    <pagination class="col-12" :route="'admin.users.index'" :data="users" @navigate="navigate"/>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import AppLoader from "@vue/components/backend/app/AppLoader"
import ListItem from "@vue/components/backend/user/ListItem.vue"
import DataFilter from "@vue/components/backend/user/DataFilter.vue"
import Pagination from "@vue/components/backend/app/Pagination"
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    props: ['page', 'role_id', 'search'],
    data() {
        return {
            users: {},
            roles: [],
            errors: {},
            loading: true,
        }
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        getUsers() {
            this.loading = true
            this.errors = {}

            axios.get('/api/users', {
                params: {...this.$props}
            }).then((response) => {
                this.users = response.data
                this.loading = false
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : {}
            })
        },
        getRoles() {
            axios.get('/api/roles/all').then((response) => {
                this.roles = response.data.data.map((role) => {
                    return { value: role.id, name: role.name }
                })
            })
        },
        removeUser(event, id) {
            event.currentTarget.disabled = true

            axios.delete('/api/users/' + id).then(() => {
                this.getUsers()

                this.showToast('success', 'User successfully removed.')
            })
        },
        filterData(params) {
            this.$router.replace({ query: params }).then(()=> {
                this.getUsers()
            });
        },
        navigate(page) {
            const newPage = (page !== 1 ? page : undefined)
            this.$router.replace({ query: { ...this.$props, page: newPage } }).then(()=> {
                this.getUsers()
            });
        },
    },
    mixins: [toastMixin],
    components: { AppLoader, Pagination, ListItem, DataFilter }
}
</script>
