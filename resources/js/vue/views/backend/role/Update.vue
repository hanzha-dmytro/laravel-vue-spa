<template>
    <main class="content">
        <app-loader class="flex-fill" v-if="loading" />
        <div class="post" v-else>
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Update {{ role.name}}</h1>
                </div>
                <div class="col-auto ms-auto text-end mt-n1">
                    <button form="role-form" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            <form-template :data="role" :errors="errors" @sendForm="saveRole" />
        </div>
    </main>
</template>

<script>
import AppLoader from "@vue/components/backend/app/AppLoader"
import FormTemplate from "@vue/components/backend/role/FormTemplate"
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    props: ['id'],
    data: () => ({
        role: {},
        errors: {},
        loading: true,
    }),
    mounted() {
        this.getRole()
    },
    methods: {
        getRole() {
            axios.get('/api/roles/' + this.id).then(response => {
                this.role = response.data.data
                this.loading = false
            })
        },
        saveRole(event, formData) {
            event.submitter.disabled = true

            formData.append("_method", "put");
            axios.post('/api/roles/' + this.id, formData).then(() => {
                this.$router.push({name: 'admin.roles.index'})
                this.errors = {}

                this.showToast('success', 'Role successfully saved.')
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : {}
                event.submitter.disabled = true
            })
        },
    },
    mixins: [toastMixin],
    components: { AppLoader, FormTemplate }
}
</script>
