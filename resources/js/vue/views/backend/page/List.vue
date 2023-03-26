<template>
    <main class="content">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-block">
                <h1 class="h4">Pages</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <router-link :to="{ name: 'admin.pages.create' }" :class="['btn btn-primary', { disabled: !$can('pages:create') }]">New Page</router-link>
            </div>
        </div>
        <div class="row flex-column flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData"/>
            <app-loader class="flex-fill" v-if="loading" />
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!pages.data.length">
                <span class="h2">There aren't pages yet!</span>
            </div>
            <div class="col-12 pages" v-else>
                <div class="row">
                    <list-item v-for="page in pages.data" :page="page" :key="page.id" @removePage="removePage" />
                    <pagination class="col-12" :route="'admin.pages.index'" :data="pages" @navigate="navigate" />
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import AppLoader from '@vue/components/backend/app/AppLoader'
    import Pagination from '@vue/components/backend/app/Pagination'
    import ListItem from "@vue/components/backend/page/ListItem";
    import DataFilter from "@vue/components/backend/page/DataFilter.vue";
    import toastMixin from "@vue/mixins/toast.mixin";

    export default {
        props: ['page', 'visibility', 'search'],
        data () {
            return {
                pages: {},
                errors: {},
                loading: true,
            }
        },
        mounted() {
            this.getPages()
        },
        methods: {
            getPages() {
                this.loading = true
                this.errors = {}

                axios.get('/api/pages', {
                    params: { ...this.$props },
                }).then((response) => {
                    this.pages = response.data
                    this.loading = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                });
            },
            removePage(event, id) {
                event.currentTarget.disabled = true

                axios.delete('/api/pages/' + id).then(() => {
                    this.getPages()

                    this.showToast('success', 'Page successfully removed.')
                })
            },
            filterData(params) {
                this.$router.replace({ query: params }).then(()=> {
                    this.getPages()
                });
            },
            navigate(page) {
                const newPage = (page !== 1 ? page : undefined)
                this.$router.replace({ query: { ...this.$props, page: newPage } }).then(()=> {
                    this.getPages()
                })
            },
        },
        mixins: [toastMixin],
        components: { AppLoader, DataFilter, ListItem, Pagination }
    }
</script>
