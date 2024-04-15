<template>
    <main>
        <app-loader class="flex-fill" v-if="loading" />

        <div class="container flex-fill" v-else>
            <primary :post="primary" />
            <latest :posts="latest" />
            <div class="row">
                <category class="col-sm-8" :title="'Latest in Category'" :posts="latest" />
                <popular class="col-sm-4" :title="'Popular'" :posts="latest" />
            </div>
        </div>
    </main>
</template>

<script>
    import AppLoader from '@vue/components/backend/app/AppLoader'
    import Primary from '@vue/components/frontend/post/Primary.vue'
    import Latest from '@vue/components/frontend/post/Latest.vue'
    import Category from "@vue/components/frontend/post/Category.vue"
    import Popular from "@vue/components/frontend/post/Popular.vue"

    export default {
        data: () => ({
            primary: {},
            latest: [],
            loading: true
        }),
        async mounted() {
            await this.getPrimary()
            await this.getPopular()

            this.loading = false
        },
        methods: {
            getPrimary() {
                return axios.get('/api/posts/primary', {
                    params: {...this.$props}
                }).then((response) => {
                    this.primary = response.data.data
                });
            },
            getPopular() {
                return axios.get('/api/posts/latest', {
                    params: {...this.$props}
                }).then((response) => {
                    this.latest = response.data.data
                });
            },
        },
        components: { AppLoader, Primary, Latest, Category, Popular },
    }
</script>
