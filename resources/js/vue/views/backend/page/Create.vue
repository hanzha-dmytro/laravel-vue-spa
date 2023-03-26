<template>
    <main class="content">
        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-block">
                <h1 class="h4">Create page</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button form="page-form" type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
        <form-template :errors="errors" @sendForm="savePage" />
    </main>
</template>

<script>
import FormTemplate from '@vue/components/backend/page/FormTemplate'
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    data: () => ({
        errors: {},
        loading: true
    }),
    methods: {
        savePage(event, formData) {
            event.submitter.disabled = true

            axios.post('/api/pages', formData).then(() => {
                this.$router.push({name: 'admin.pages.index'})
                this.errors = {}

                this.showToast('success', 'Page successfully created.')
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : {}
                event.submitter.disabled = false
            })
        },
    },
    mixins: [toastMixin],
    components: { FormTemplate }
}
</script>
