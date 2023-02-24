<template>
    <main class="content">
        <div class="row mb-2">
            <div class="col-auto d-block">
                <h1 class="h4">Roles</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <router-link :to="{ name: 'admin.roles.create' }" :class="['btn btn-primary', { disabled: !$can('roles:create') }]">New Role</router-link>
            </div>
        </div>
        <div class="row flex-column flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData" />
            <app-loader class="flex-fill" v-if="loading"/>
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!roles.data.length">
                <span class="h2">There aren't roles yet!</span>
            </div>
            <div class="col-12 users" v-else>
                <div class="row">
                    <list-item v-for="role in roles.data" :role="role" :key="role.id" @removeRole="removeRole"/>
                    <pagination class="col-12" :route="'admin.roles.index'" :data="roles" @navigate="navigate" />
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import AppLoader from "@vue/components/backend/app/AppLoader"
import ListItem from "@vue/components/backend/role/ListItem.vue"
import Pagination from "@vue/components/backend/app/Pagination"
import DataFilter from "@vue/components/backend/role/DataFilter.vue";
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    props: ['page', 'search'],
    data() {
        return {
            roles: {},
            errors: {},
            loading: true,
        }
    },
    mounted() {
        this.getRoles()
    },
    methods: {
        getRoles() {
            this.loading = true
            this.errors = {}

            axios.get('/api/roles', {
                params: {...this.$props}
            }).then((response) => {
                this.roles = response.data
                this.loading = false
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : {}
            });
        },
        removeRole(id) {
            axios.delete('/api/roles/' + id).then(() => {
                this.getRoles()

                this.showToast('success', 'Role successfully removed.')
            })
        },
        filterData(params) {
            this.$router.replace({ query: params }).then(()=> {
                this.getRoles()
            });
        },
        navigate(page) {
            const newPage = (page !== 1 ? page : undefined)
            this.$router.replace({ query: { ...this.$props, page: newPage  } }).then(()=> {
                this.getRoles()
            });
        },
    },
    mixins: [toastMixin],
    components: {AppLoader, Pagination, ListItem, DataFilter }
}
</script>
