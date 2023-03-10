<template>
    <main class="content">
        <div class="row mb-2">
            <div class="col-auto d-block">
                <h1 class="h4">Categories</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button form="category-form" class="btn btn-primary" :disabled="!$can('categories:create')" @click.prevent="createCategory">New Category</button>
            </div>
        </div>
        <div class="row flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData" />
            <app-loader class="flex-fill" v-if="loading" />
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!categories.data.length">
                <span class="h2">There aren't categories yet!</span>
            </div>
            <div class="col-12" v-else>
                <div class="row">
                    <div class="col order-1 order-md-0 categories">
                        <div class="row">
                            <list-item v-for="category in categories.data" :category="category" :key="category.id" @removeCategory="removeCategory" @editCategory="editCategory"/>
                            <pagination class="col-12" :route="'admin.categories.index'" :data="categories" @navigate="navigate" />
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-4 order-0 order-md-1" v-if="$can('categories:update') || $can('categories:create')">
                        <form-template :data="category" :errors="errors" @sendForm="saveCategory" :key="category.id ? category.id : 0 "/>
                    </div>
                </div>
            </div>

        </div>
    </main>
</template>

<script>
    import AppLoader from '@vue/components/backend/app/AppLoader'
    import FormTemplate from '@vue/components/backend/category/FormTemplate.vue'
    import Pagination from '@vue/components/backend/app/Pagination'
    import ListItem from "@vue/components/backend/category/ListItem.vue";
    import DataFilter from "@vue/components/backend/category/DataFilter.vue";
    import toastMixin from "@vue/mixins/toast.mixin";

    export default {
        props: ['page', 'search'],
        data () {
            return {
                categories: {},
                category: {},
                errors: {},
                loading: true,
            }
        },
        mounted() {
            this.getCategories()
        },
        methods: {
            getCategories() {
                this.loading = true
                this.errors = {}

                axios.get('/api/categories', {
                    params: { ...this.$props }
                }).then((response) => {
                    this.categories = response.data
                    this.loading = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                })
            },
            createCategory() {
                this.category = {}
                this.errors = {}
            },
            editCategory(id) {
                this.category = this.categories.data.find((category) => {
                    return category.id === id;
                })
                this.errors = {}
            },
            saveCategory(event, formData) {
                if(this.category.id) {
                    this.updateCategory(event, this.category.id, formData)
                } else {
                    this.storeCategory(event, formData)
                }
            },
            storeCategory(event, formData) {
                event.submitter.disabled = true
                axios.post('/api/categories', formData).then(() => {
                    this.getCategories()

                    this.showToast('success', 'Category successfully created.')
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }).then(() => {
                    event.submitter.disabled = false
                })
            },
            updateCategory(event, id, formData) {
                event.submitter.disabled = true
                formData.append("_method", "put")
                axios.post('/api/categories/' + id, formData).then((response) => {
                    let idx = this.categories.data.findIndex((category) => {
                        return category.id === response.data.data.id
                    })
                    this.$set(this.categories.data, idx, response.data.data)
                    this.category = {}
                    this.errors = {}

                    this.showToast('success', 'Category successfully saved.')
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }).then(() => {
                    event.submitter.disabled = false
                })
            },
            removeCategory(event, id) {
                event.currentTarget.disabled = true
                axios.delete('/api/categories/' + id).then(() => {
                    this.getCategories()

                    this.showToast('success', 'Category successfully removed.')
                })
            },
            filterData(params) {
                this.$router.replace({ query: params }).then(()=> {
                    this.getCategories()
                });
            },
            navigate(page) {
                const newPage = (page !== 1 ? page : undefined)
                this.$router.replace({ query: { ...this.$props, page: newPage  } }).then(()=> {
                    this.getCategories()
                });
            }
        },
        mixins: [toastMixin],
        components: { AppLoader, DataFilter, FormTemplate, ListItem, Pagination }
    }
</script>
