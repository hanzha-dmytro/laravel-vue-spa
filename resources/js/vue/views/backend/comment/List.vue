<template>
    <main class="content">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-block">
                <h1 class="h4">Comments</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button form="comment-form" class="btn btn-primary" :disabled="!$can('comments:create')" @click.prevent="createComment">New comment</button>
            </div>
        </div>
        <div class="row flex-column flex-fill ">
            <data-filter :errors="errors" :values="$props" @filterData="filterData" />
            <app-loader class="flex-fill" v-if="loading" />
            <div class="col-12 d-flex flex-fill align-items-center justify-content-center" v-else-if="!comments.data.length">
                <span class="h2">There aren't comments yet!</span>
            </div>
            <div class="col-12" v-else>
                <div class="row">
                    <div class="col order-1 order-md-0 comments">
                        <div class="row">
                            <list-item v-for="comment in comments.data" :comment="comment" :key="comment.id" @removeComment="removeComment" @changeStatus="changeStatus" @editComment="editComment"/>
                            <pagination class="col-12" :route="'admin.comments.index'" :data="comments" @navigate="navigate" />
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-4 order-0 order-md-1" v-if="$can('comments:update') || $can('comments:create')">
                        <form-template :data="comment" :errors="errors" @sendForm="saveComment" :key="comment?.id ?? 0 "/>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import AppLoader from '@vue/components/backend/app/AppLoader'
    import ListItem from "@vue/components/backend/comment/ListItem.vue";
    import DataFilter from "@vue/components/backend/comment/DataFilter.vue";
    import FormTemplate from "@vue/components/backend/comment/FormTemplate.vue";
    import Pagination from "@vue/components/backend/app/Pagination.vue";
    import toastMixin from "@vue/mixins/toast.mixin";

    export default {
        props: ['page', 'search', 'visibility'],
        data() {
            return {
                comments: {},
                comment: {},
                errors: {},
                loading: true,
            }
        },
        mounted() {
            this.getComments()
        },
        methods: {
            getComments() {
                this.loading = true
                this.errors = {}

                axios.get(`/api/comments`, {
                    params: {...this.$props}
                }).then((response) => {
                    this.comments = response.data
                    this.loading = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                });
            },
            createComment() {
                this.comment = {}
                this.errors = {}
            },
            editComment(event, id) {
                this.comment = this.comments.data.find((comment) => {
                    return comment.id === id;
                })
                this.errors = {}
            },
            saveComment(event, formData) {
                if(this.comment.id) {
                    this.updateComment(event, this.comment.id, formData)
                } else {
                    this.storeComment(event, formData)
                }
            },
            storeComment(event, formData) {
                event.submitter.disabled = true
                axios.post('/api/comments', formData).then(() => {
                    this.getComments()
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }).then(() => {
                    event.submitter.disabled = false
                })
            },
            updateComment(event, id, formData) {
                event.submitter.disabled = true
                formData.append("_method", "put")
                axios.post('/api/comments/' + id, formData).then((response) => {
                    let idx = this.comments.data.findIndex((comment) => {
                        return comment.id === response.data.data.id
                    })
                    this.$set(this.comments.data, idx, response.data.data)
                    this.comment = {}
                    this.errors = {}
                }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }).then(() => {
                    event.submitter.disabled = false
                })
            },
            changeStatus(event, comment) {
                const button = event.currentTarget

                button.disabled = true
                axios.put(`/api/comments/${comment.id}/status/`, {is_visible: !comment.is_visible}).then((response) => {
                    let idx = this.comments.data.findIndex((comment) => {
                        return comment.id === response.data.data.id
                    })
                    this.$set(this.comments.data, idx, response.data.data)

                    this.showToast('success', `Comment status changed to ${comment.is_visible ? 'approved' : 'unapproved'}.`)
                }).then(() => {
                    button.disabled = false
                })
            },
            removeComment(event, id) {
                event.currentTarget.disabled = true

                axios.delete(`/api/comments/${id}`).then(() => {
                    this.getComments()

                    this.showToast('success', 'Comment successfully removed.')
                })
            },
            filterData(params) {
                this.$router.replace({query: params}).then(() => {
                    this.getComments()
                });
            },
            navigate(page) {
                const newPage = (page !== 1 ? page : undefined)
                this.$router.replace({query: {...this.$props, page: newPage}}).then(() => {
                    this.getComments()
                });
            },
        },
        mixins: [toastMixin],
        components: { AppLoader, DataFilter, ListItem, FormTemplate, Pagination }
    }
</script>
