<template>
    <main class="content">
        <div class="row mb-2">
            <div class="col-auto d-block">
                <h1 class="h4">Create user</h1>
            </div>
            <div class="col-auto ms-auto text-end mt-n1">
                <button form="user-form" type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
        <form-template :errors="errors" @sendForm="saveUser" />
    </main>
</template>

<script>
import FormTemplate from "@vue/components/backend/user/FormTemplate"
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    data: () => ({
        errors: {},
        loading: true
    }),
    methods: {
        saveUser(event, formData) {
            event.submitter.disabled = true

            axios.post('/api/users', formData).then(() => {
                this.$router.push({name: 'admin.users.index'})
                this.errors = {}

                this.showToast('success', 'User successfully created.')
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
