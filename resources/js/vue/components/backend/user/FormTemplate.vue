<template>
    <form id="user-form" @submit.prevent="sendForm">
        <div class="row">
            <div class="col-lg-8 col-xl-9 mb-3 mb-lg-0">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Personal information</h6>
                    </div>
                    <div class="card-body">
                        <form-input v-model="form.name" type="text" label="Name" placeholder="Type name" class="mb-3" :errors="errors.name" />
                        <form-input v-model="form.email" type="email" label="Email" placeholder="Type email" class="mb-3" :errors="errors.email" />
                        <form-input v-model="form.password" type="password" label="Password" placeholder="Type password" class="mb-3" :errors="errors.password" />
                        <form-multiselect v-model.number="form.role_id" :options="roles" label="Role" placeholder="Select a role" class="mb-3" :errors="errors.role_id" :disabled="!$can('roles:read')" />
                        <form-multiselect v-model="form.permissions" :options="permissions" label="Permissions" type="taggable" :searchable="true" class="mb-3" :errors="errors.permissions" :disabled="!$can('permissions:read')" />
                        <form-text-area v-model="form.description" label="Description" placeholder="Type description" class="mb-3" :errors="errors.description" />
                        <form-check-box v-model="form.is_active" label="Active"  class="form-switch" :errors="errors.is_active" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Avatar</h6>
                    </div>
                    <div class="card-body">
                        <form-image :value="data ? data.avatar : ''" :width="260" :height="260" file-type="image/jpeg" fill-color="#fff" :errors="errors.avatar" @change="avatar => form.avatar = avatar"/>
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
import FormSelect from "../form/FormSelect";
import FormMultiselect from "../form/FormMultiselect";
import sendFormMixin from "@vue/mixins/send-form.mixin";
import FormCheckBox from "@vue/components/backend/form/FormCheckBox.vue";

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
                name: this.data?.name ?? '',
                email: this.data?.email ?? '',
                description: this.data?.description ?? '',
                avatar: '',
                password: '',
                role_id: this.data?.role?.id ?? '',
                permissions: this.data?.permissions ?? [],
                is_active : !!(this.data?.is_active ?? 1),
            },
            roles: [],
            permissions: [],
        }
    },
    mounted() {
        this.getRoles()
        this.getPermissions()
    },
    methods: {
        getRoles() {
            axios.get('/api/roles/all').then((response) => {
                this.roles = response.data.data.map((role) => {
                    return { value: role.id, name: role.name }
                })
            })
        },
        getPermissions() {
            axios.get('/api/permissions').then((response) => {
                this.permissions = response.data.data.map((permission) => {
                    return { value: permission, name: permission }
                })
            })
        }
    },
    mixins: [sendFormMixin],
    components: {FormCheckBox, FormImage, FormInput, FormTextArea, FormSelect, FormMultiselect},

}
</script>
