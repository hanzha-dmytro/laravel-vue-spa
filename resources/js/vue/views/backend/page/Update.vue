<template>
    <main class="content">
        <app-loader class="flex-fill" v-if="loading" />
        <div class="page" v-else>
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Update page {{ page.title }}</h1>
                </div>
                <div class="col-auto ms-auto text-end mt-n1">
                    <button form="page-form" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            <form-template :data="page" :errors="errors" @sendForm="savePage" />
        </div>
    </main>
</template>

<script>
import AppLoader from '@vue/components/backend/app/AppLoader'
import FormTemplate from '@vue/components/backend/page/FormTemplate'
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    props: ['id'],
    data: () => ({
        page: {},
        errors: {},
        loading: true,
    }),
    mounted() {
        this.getPage()
    },
    methods: {
        getPage() {
            axios.get('/api/pages/' + this.id).then(response => {
                this.page = response.data.data
                this.loading = false
            })
        },
        savePage(event, formData) {
            event.submitter.disabled = true

            formData.append("_method", "put");
            axios.post('/api/pages/' + this.id, formData).then(() => {
                this.$router.push({name: 'admin.pages.index'})
                this.errors = {}

                this.showToast('success', 'Page successfully saved.')
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : {}
                event.submitter.disabled = false
            })
        },
    },
    mixins: [toastMixin],
    components: { AppLoader, FormTemplate }
}
</script>
