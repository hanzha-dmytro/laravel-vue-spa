<template>
    <main class="content">
        <div class="d-flex h-100 align-items-center">
            <div class="d-flex flex-column container">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
                    <div class="text-center mb-3">
                        <h1 class="h3">Change password</h1>
                    </div>
                    <div class="card">
                        <div class="card-body m-sm-3">
                            <form method="POST" @submit.prevent="reset">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input v-model="email" id="email" type="email" placeholder="Enter your email" :class="['form-control', {'is-invalid': errors.email}]">
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ errors.email ? errors.email[0] : '' }}</strong>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label for="password"  class="form-label">Password</label>
                                    <input v-model="password" id="password" type="password" placeholder="Enter your password" :class="['form-control', {'is-invalid': errors.password}]">
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ errors.password ? errors.password[0] : '' }}</strong>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label for="password"  class="form-label">Password confirmation</label>
                                    <input v-model="password_confirmation" id="password_confirmation" type="password" placeholder="Confirm your password" :class="['form-control', {'is-invalid': errors.password_confirmation}]">
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ errors.password_confirmation ? errors.password_confirmation[0] : '' }}</strong>
                                    </span>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">Change</button>
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
        props: ['token'],
        data() {
            return {
                email: '',
                password: '',
                password_confirmation: '',
                remember: false,
                errors: [],
                loading: false
            }
        },
        methods: {
            reset() {
                this.loading = true
                axios.post('/api/auth/reset-password', {
                    token: this.token,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }).then(() => {
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
