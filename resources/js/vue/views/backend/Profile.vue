<template>
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2">
                <div class="col-auto d-block">
                    <h1 class="h4">Profile</h1>
                </div>
                <div class="col-auto ms-auto text-end mt-n1">
                    <button form="profile-form" type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            <form-template :data="user" :errors="errors" @sendForm="saveProfile" />
        </div>
    </main>
</template>

<script>
    import store from "@vue/store";
    import FormTemplate from "@vue/components/backend/profile/FormTemplate";
    import toastMixin from "@vue/mixins/toast.mixin";

    export default {
        data() {
            return {
                errors: {},
                loading: true,
            }
        },
        methods: {
            saveProfile(event, formData) {
                event.submitter.disabled = true

                formData.append("_method", "put");
                axios.post('/api/profile/', formData).then((response) => {
                    this.$store.commit('auth/setUserData', response.data.data)
                    this.errors = {}

                    this.showToast('success', 'Profile successfully updated.')
                    event.submitter.disabled = false
                }).catch(error => {
                    this.errors = error.response.status === 422 ? error.response.data.errors : {}
                    event.submitter.disabled = false
                })
            },
        },
        computed: {
            user: () => {
                return store.getters['auth/user']
            }
        },
        mixins: [toastMixin],
        components: { FormTemplate }
    }
</script>
