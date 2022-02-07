<template>
    <main class="content">
        <div class="d-flex h-100 align-items-center">
            <div class="d-flex flex-column container">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
                    <div class="text-center mb-3">
                        <h1 class="h3">Remind password</h1>
                    </div>
                    <div class="card">
                        <div class="card-body m-sm-3">
                            <form method="POST" @submit.prevent="restore">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input v-model="email" id="email" type="email" placeholder="Enter your email" :class="['form-control', {'is-invalid': errors.email}]">
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ errors.email ? errors.email[0] : '' }}</strong>
                                    </span>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">Restore password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            errors: [],
            loading: false
        }
    },
    methods: {
        restore() {
            this.loading = true
            axios.post('/api/auth/forgot-password', { email: this.email }).then(() => {
                this.$router.push({ name: 'admin.auth.login' })
            }).catch(error => {
                this.errors = error.response.status === 422 ? error.response.data.errors : []
            }).then(() => {
                this.loading = false
            })
        }
    }
}
</script>
