<template>
    <form id="profile-form" class="needs-validation" novalidate @submit.prevent="sendForm">
        <div class="row">
            <div class="col-lg-8 col-xl-9 mb-3 mb-lg-0">
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Personal information</h6>
                    </div>
                    <div class="card-body h-100">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model="form.email" type="email" label="Email" placeholder="Type email" class="mb-3" :errors="errors.email" />
                        <form-text-area v-model="form.description" :rows="3" label="About" placeholder="Type about" :errors="errors.description" />
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Security</h6>
                    </div>
                    <div class="card-body h-100">
                        <form-input v-model="form.password" type="password" label="Password" placeholder="Type password" class="mb-3" :errors="errors.password" />
                        <form-input v-model="form.password_confirmation" type="password" label="Password confirm" placeholder="Confirm your password" class="mb-3" :errors="errors.password_confirmation" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Avatar</h6>
                    </div>
                    <div class="card-body text-center">
                        <form-image :value="data.avatar" :width="260" :height="260" file-type="image/jpeg" fill-color="#fff" :errors="errors.avatar" @change="avatar => form.avatar = avatar"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import FormImage from "../form/FormImage";
    import FormInput from "../form/FormInput";
    import FormTextArea from "../form/FormTextArea";
    import sendFormMixin from "@vue/mixins/send-form.mixin";

    export default {
        props: {
            data: {
                type: Object,
                default: () => {},
            },
            errors: {
                type: Object,
                default: () => {},
            },
        },
        data () {
            return {
                form: {
                    name: this.data.name ?? '',
                    email: this.data.email ?? '',
                    description: this.data.description ?? '',
                    avatar: '',
                    password: '',
                    password_confirmation: '',
                },
                roles: []
            }
        },
        mounted() {
            this.getCategories()
        },
        methods: {
            getCategories() {
                axios.get('/api/roles/all').then((response) => {
                    this.roles = response.data.data.map((role) => {
                        return { value: role.id, name: role.name }
                    })
                })
            },
        },
        mixins: [sendFormMixin],
        components: { FormImage, FormInput, FormTextArea },
    }
</script>
