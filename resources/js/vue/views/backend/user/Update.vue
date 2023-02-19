<template>
    <main class="content">
        <app-loader class="flex-fill" v-if="loading" />
        <div class="post" v-else>
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Update {{ user.name}}</h1>
                </div>
                <div class="col-auto ms-auto text-end mt-n1">
                    <button form="user-form" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            <form-template :data="user" :errors="errors" @sendForm="saveUser" />
        </div>
    </main>
</template>

<script>
import AppLoader from "@vue/components/backend/app/AppLoader"
import FormTemplate from "@vue/components/backend/user/FormTemplate"
import toastMixin from "@vue/mixins/toast.mixin";

export default {
    props: ['id'],
    data: () => ({
        user: {},
        errors: {},
        loading: true,
    }),
    mounted() {
        this.getUser()
    },
    methods: {
        getUser() {
            axios.get('/api/users/' + this.id).then(response => {
                this.user = response.data.data
                this.loading = false
            })
        },
        saveUser(event, formData) {
            event.submitter.disabled = true

            formData.append("_method", "put");
            axios.post('/api/users/' + this.id, formData).then(() => {
                this.$router.push({name: 'admin.users.index'})
                this.errors = {}

                this.showToast('success', 'User successfully saved.')
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
