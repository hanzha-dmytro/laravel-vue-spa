<template>
    <main class="content">
        <div class="row mb-2">
            <div class="col-auto d-block">
                <h1 class="h4">Posts</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <router-link :to="{ name: 'admin.posts.create' }" :class="['btn btn-primary', { disabled: !$can('posts:create') }]">New Post</router-link>
            </div>
        </div>
        <div class="row flex-column flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData"/>
            <app-loader class="flex-fill" v-if="loading" />
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!posts.data.length">
                <span class="h2">There aren't posts yet!</span>
            </div>
            <div class="col-12 posts" v-else>
                <div class="row">
                    <list-item v-for="post in posts.data" :post="post" :key="post.id" @removePost="removePost" />
                    <pagination class="col-12" :route="'admin.posts.index'" :data="posts" @navigate="navigate" />
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import AppLoader from '@vue/components/backend/app/AppLoader'
    import Pagination from '@vue/components/backend/app/Pagination'
    import ListItem from "@vue/components/backend/post/ListItem";
    import DataFilter from "@vue/components/backend/post/DataFilter.vue";
    import toastMixin from "@vue/mixins/toast.mixin";

    export default {
        props: ['page', 'category_id', 'search'],
        data () {
            return {
                posts: {},
                errors: {},
                loading: true,
            }
        },
        mounted() {
            this.getPosts()
        },
        methods: {
            getPosts() {
                this.loading = true
                this.errors = {}

                axios.get('/api/posts', {
                    params: { ...this.$props }
                }).then((response) => {
                    this.posts = response.data
                    this.loading = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                })
            },
            removePost(event, id) {
                event.currentTarget.disabled = true

                axios.delete('/api/posts/' + id).then(() => {
                    this.getPosts()

                    this.showToast('success', 'Post successfully removed.')
                })
            },
            filterData(params) {
                this.$router.replace({ query: params }).then(()=> {
                    this.getPosts()
                });
            },
            navigate(page) {
                const newPage = (page !== 1 ? page : undefined)
                this.$router.replace({ query: { ...this.$props, page: newPage } }).then(()=> {
                    this.getPosts()
                });
            },
        },
        mixins: [toastMixin],
        components: { AppLoader, DataFilter, ListItem, Pagination }
    }
</script>
